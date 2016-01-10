<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class ProductsCategory extends Model
{
    protected $table = 'categories_products';

    public static $rules = [
        'title' => 'required|between:3,255',
        'parent_id' => ''
    ];

    public static function messages($key = null) {
        $messages = [
            'title.required' => 'Category title is required.',
            'title.between' => 'Category title length must between 3, 255.',
        ];
        if($key) return $messages[$key];
        return $messages;
    }

    public function childs() {
        return $this -> hasMany('App\ProductsCategory', 'parent_id');
    }

    public function parent() {
        return $this -> belongsTo('App\ProductsCategory', 'parent_id');
    }

    public function products() {
        return $this -> hasMany('App\Product', 'category_id');
    }

    public function mainParent() {
        $mainParent = $this -> parent;
        if($mainParent) {
            while($mainParent -> parent) $mainParent = $mainParent -> parent;
        }

        if(!$mainParent) $mainParent = $this;

        return $mainParent;
    }

    public static function newRecord($data) {
        $category = new ProductsCategory();
        $rules = self::rules;
        $messages = self::messages();
        $validator = Validator::make($data, $rules, $messages);
        if($validator -> fails()) {
            return [
                'error' => [
                    'type' => 'invalidData',
                    'responseMessages' => $validator
                ],
                'success' => 0
            ];
        }

        $category -> title = $data['title'];
        $category -> parent_id = $data['parent'];
        $category -> save();

        return [
            'error' => 0,
            'success' => 'You created category successfully',
        ];
    }

    public static function newRecordByTranslation($data) {
        $rules = self::$rules;
        $messages = self::messages();
        $validator = Validator::make($data, $rules, $messages);
        if($validator -> fails()) {
            return [
                'code' => 400,
                'type' => 'InvalidData',
                'messages' => $validator
            ];
        }

        try {
            $newCategory = new ProductsCategory();
            $newCategory -> save();
        } catch(\Exception $exception) {
            return [
                'code' => 400,
                'type' => 'SavingException',
                'message' => $exception -> getMessage(),
                'trace' => $exception -> getTraceAsString(),
                'redirect' => 'back'
            ];
        }

        $translationResponse = ProductCategoryTranslation::createNew([
            'category_id' => $newCategory -> id,
            'locale' => $data['locale'],
            'title' => $data['title']
        ]);

        return $translationResponse;
    }

    public static function editRecord($id, $data) {
        $category = ProductsCategory::find($id);
        $existChecker = ProductsCategory::checkExisting($category, $id);
        if($existChecker['error']['code']) return $existChecker['error']['data'];
        $rules = $category -> rules;
        $messages = $category -> messages();
        $validator = Validator::make($data, $rules, $messages);
        if($validator -> fails()) {
            return [
                'error' => [
                    'type' => 'invalidData',
                    'responseMessages' => $validator
                ],
                'success' => 0
            ];
        }
        $category -> title = $data['title'];
        $category -> parent_id = $data['parent'];
        $category -> save();

        return [
            'error' => 0,
            'success' => 'You edited category "' . $category -> title . '" successfully',
        ];
    }

    public static function checkExisting($category, $id) {
        if(!$category) {
            $categories = ProductsCategory::all();
            if(!$categories -> count()) {
                return [
                    'error' => [
                        'code' => 1,
                        'type' => 'noRecords',
                        'data' => [
                            'message' => 'No categories exist.',
                            'links' => [
                                [
                                    'url' => 'panel/products/categories',
                                    'text' => 'Go to table '
                                ]
                            ]
                        ]
                    ]
                ];
            }
            $firstCategory = $categories[0];
            $middleCategory = $categories[intval((count($categories) - 1) / 2)];
            $lastCategory = $categories[count($categories) - 1];

            $firstDiff = abs($firstCategory -> id - $id);
            $middleDiff = abs($middleCategory -> id - $id);
            $lastDiff = abs($lastCategory -> id - $id);

            if($firstDiff < $middleDiff && $firstDiff < $lastDiff) $categoryLF = $firstCategory;
            else if($firstDiff > $middleDiff && $middleDiff < $lastDiff) $categoryLF = $middleCategory;
            else if($firstDiff > $lastDiff && $middleDiff > $lastDiff) $categoryLF = $lastCategory;
            else $categoryLF = $firstCategory;

            $links = [
                [
                    'url' => 'panel/products/categories',
                    'text' => 'Go to table'
                ],
                [
                    'url' => 'panel/products/categories/' . $categoryLF -> id . '/edit',
                    'text' => 'May be you looking for "' . $categoryLF -> title . '" category.'
                ]
            ];
            if($firstDiff != $middleDiff && $firstDiff != $lastDiff && $middleDiff != $lastDiff) {
                $links[2] = [
                    'url' => null,
                    'text' => 'Or you want other categories?'
                ];
                $links[3] = [
                    'url' => 'panel/products/categories/' . $firstCategory -> id . '/edit',
                    'text' => '1. "' . $firstCategory -> title . '" category.'
                ];
                $links[4] = [
                    'url' => 'panel/products/categories/' . $middleCategory -> id . '/edit',
                    'text' => '2. "' . $middleCategory -> title . '" category.'
                ];
                $links[5] = [
                    'url' => 'panel/products/categories/' . $lastCategory -> id . '/edit',
                    'text' => '3. "' . $lastCategory -> title . '" category.'
                ];
            }

            return [
                'error' => [
                    'code' => 1,
                    'type' => 'noExist',
                    'data' => [
                        'message' => 'Category with this id does not exist.',
                        'links' => $links
                    ]
                ]
            ];
        }

        return [
            'error' => [
                'type' => 'none',
                'code' => 0
            ]
        ];
    }
}
