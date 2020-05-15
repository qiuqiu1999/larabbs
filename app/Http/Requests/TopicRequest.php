<?php

namespace App\Http\Requests;

class TopicRequest extends Request
{
    public function rules()
    {
        $rule1 = [
            'title' => 'required|min:2',
            'body' => 'required|min:3',
            'category_id' => 'required|numeric',
        ];


        switch ($this->method()) {

            // CREATE
            case 'POST':
                {
                    return $rule1;
                }
            // UPDATE
            case 'PUT':
                {
                    return $rule1;
                }
            case 'PATCH':
                {
                    return $rule1;
                }
            case 'GET':
            case 'DELETE':
            default:
                {
                    return [];
                }
        }
    }

    public function messages()
    {
        return [
            'title.min' => '标题必须至少两个字符',
            'body.min' => '文章内容必须至少三个字符',
        ];
    }
}
