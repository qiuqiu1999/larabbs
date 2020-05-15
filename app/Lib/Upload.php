<?php


namespace App\Lib;


class Upload
{
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];
    private $fileType;

    public function save($file, $max_width = false)
    {
        if (!$file->isValid()) {
            return  false;
        }
        $this->fileType = $file->getClientOriginalExtension();

        $this->checkType();
        $fileName = time() . uniqid() . '.' . $this->fileType;
        $savePath = 'uploads/' . date('Y') . '/'. date('m') . '/' . date('d');

        if ($result = $file->move($savePath, $fileName)) {
            if ($max_width && $this->fileType != 'gif') {
                // 此类中封装的函数，用于裁剪图片
                $this->reduceSize("{$savePath}/{$fileName}", $max_width);
            }
            $returnPath = "/{$savePath}/{$fileName}";

//            var_dump($returnPath);exit;
            return ['path' => $returnPath];
        }
        return false;
    }


    protected function checkType()
    {
        if (empty($this->fileType) || !in_array($this->fileType, $this->allowed_ext)) {
            throw new \Exception("上传类型错误");
        }
        return true;
    }

    public function reduceSize($file_path, $max_width)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = \Image::make($file_path);
        // 进行大小调整的操作
        $image->resize($max_width, null, function ($constraint) {
            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();
            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });
        // 对图片修改后进行保存
        $image->save();
    }

//    protected function checkSize()
//    {
//        if (false) {
//            throw new \Exception("上传文件超出限制大小");
//        }
//        return true;
//    }


}