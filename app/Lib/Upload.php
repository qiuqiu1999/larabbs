<?php


namespace App\Lib;


class Upload
{
    protected $allowed_ext = ["png", "jpg", "gif", 'jpeg'];
    private $fileType;

    public function save($file)
    {
        if (!$file->isValid()) {
            return  false;
        }
        $this->fileType = $file->getClientOriginalExtension();

        $this->checkType();
        $fileName = time() . uniqid() . '.' . $this->fileType;
        $savePath = 'public/uploads/' . date('Y') . '/'. date('m') . '/' . date('d');

        if ($result = $file->move($savePath, $fileName)) {
            $returnPath = "/{$savePath}/{$fileName}";
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

//    protected function checkSize()
//    {
//        if (false) {
//            throw new \Exception("上传文件超出限制大小");
//        }
//        return true;
//    }
}