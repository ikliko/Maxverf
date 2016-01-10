<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\Validator;

class ProductCategoryTranslation extends Model {
    protected $table = 'product_category_translations';

    protected $timestamps = false;

    private static function rules() {
        $rules = [
            'category_id' => 'required|integer',
            'locale' => 'required',
            'title' => 'required|between:3,255'
        ];

        return $rules;
    }

    private static function messages() {
        $messages = [
            'category_id.required' => 'Select category, please',
            'category_id.integer' => 'Invalid category',
            'locale.required' => 'Enter locale, please',
            'title.required' => 'Enter title, please',
            'title.between' => 'Title length must between :min and :max',
        ];

        return $messages;
    }

    public static function createNew($data) {
        if(!Auth::check()) {
            return [
                'code' => 401,
                'type' => 'Unauthorized',
                'message' => 'Log in please',
                'redirect' => url('/panel/login')
            ];
        }

        $rules = self::rules();
        $messages = self::messages();
        $validator = Validator::make($data, $rules, $messages);
        if($validator -> fails()) {
            return [
                'code' => 400,
                'type' => 'InvalidData',
                'messages' => $validator,
                'redirect' => 'back'
            ];
        }

        try {
            $new = new ProductCategoryTranslation();
        } catch(\Exception $exception) {
            return [
                'code' => 400,
                'type' => 'SavingException',
                'message' => $exception -> getMessage(),
                'trace' => $exception -> getTraceAsString(),
                'redirect' => 'back'
            ];
        }

        return [
            'code' => 200,
            'type' => 'Success',
            'message' => 'You successfully created new translation',
            'redirect' => 'back'
        ];
    }
}
