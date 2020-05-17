<?php


/**
 * Http服务器
 * Class Http
 */
class Http
{
    private $http;
    public function __construct()
    {
        $this->http = new \Swoole\Http\Server('0.0.0.0', 9501);
        $this->http->on('request', [$this, 'onRequest']);
        $this->http->on('workerStart', [$this, 'onWorkerStart']);
        $this->http->set([
            'enable_static_handler' => true,
//            'document_root'         => __DIR__ . '/public/static',
            'worker_num'            => 3,
        ]);
        $this->http->start();
    }

    public function onWorkerStart($server,$worker_id)
    {
        global $kernel;
        define('LARAVEL_START', microtime(true));
        require __DIR__.'/../vendor/autoload.php';
        $app = require_once __DIR__.'/../bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    }

    public function onRequest($request, $response)
    {
        var_dump('接收到请求');
        // 拒绝ico请求
        if($request->server['request_uri'] == '/favicon.ico') {
            $response->status(404);
            $response->end();
            return ;
        }

        $_POST = [];
        if (isset($request->post)) {
            foreach ($request->post as $key => $value) {
                $_POST[strtoupper($key)] = $value;
            }
        }
        $_GET = [];
        if (isset($request->get)) {
            foreach ($request->get as $key => $value) {
                $_GET[strtoupper($key)] = $value;
            }
        }
        $_SERVER = [];
        if (isset($request->server)) {
            foreach ($request->server as $key => $value) {
                $_SERVER[strtoupper($key)] = $value;
            }
        }
        if (isset($request->header)) {
            foreach ($request->header as $key => $value) {
                $_SERVER[strtoupper($key)] = $value;
            }
        }
        $_FILES = [];
        if (isset($request->files)) {
            foreach ($request->files as $key => $value) {
                $_FILES[strtoupper($key)] = $value;
            }
        }

        try {
            ob_start();

            $result = ob_get_contents();
            ob_end_clean();
            $response = $kernel->handle(
                $request = Illuminate\Http\Request::capture()
            );

            $response->send();

            $kernel->terminate($request, $response);

//            $response->header('Content-Type', 'text/html');
//            $response->header('Charset', 'utf-8');
//            $response->end($result);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }
}

new Http();
