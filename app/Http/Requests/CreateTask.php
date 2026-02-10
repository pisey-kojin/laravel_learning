<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:100',
            'due_date' => 'required|date|after_or_equal:today',
        ];
    }

    /**
     * リクエストのnameの値を再定義
     * 
     */
    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'due_dte' => '期限日',
        ];
    }

    /**
     * FormRequestクラス単位でエラーメッセージを定義する
     * 
     * @return array<string>
     */
    public function message()
    {
        return [
            'due_date.after_or_equal' => ':attribute には今日以降の日付を入力してください。',
        ];
    }
}
