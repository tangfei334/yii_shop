<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "demo".
 *
 * @property int $id
 * @property string $name 名称
 * @property string $icon 图标
 * @property string $url 地址
 * @property int $prent_id 父类ID
 */
class Demo extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['prent_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名称',
            'icon' => '图标',
            'url' => '地址',
            'prent_id' => '父类ID',
        ];
    }
    public static function demo(){

//        $demo=[
//            ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
//            [
//                'label' => '品牌管理',
//                'icon' => 'share',
//                'url' => '#',
//                'items' => [
//                    ['label' => '品牌列表', 'icon' => 'file-code-o', 'url' => ['/brand/index'],],
//                    ['label' => '品牌添加', 'icon' => 'dashboard', 'url' => ['/brand/add'],],
//                    [
//                        'label' => 'Level One',
//                        'icon' => 'circle-o',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
//                            [
//                                'label' => 'Level Two',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                            ],
//                        ],
//                    ],
//                ],
//            ],
//        ];
        $demoAll=[];
        //得到所有一级目录
        $demos=self::find()->where(['parent_id'=>0])->all();
//        var_dump($demos);exit;
//
        foreach ($demos as $demo){
            $newDemo=[];
            $newDemo['label']=$demo->name;
            $newDemo['icon']=$demo->icon;
            $newDemo['url']=$demo->url;
//            var_dump($newDemo); exit;
            //通过一级菜单找到所有二级菜单
            $demosSon=self::find()->where(['parent_id'=>$demo->id])->all();

            //再次循环
            foreach ($demosSon as $demoSon){
                $newDemoSon=[];
                $newDemoSon['label']=$demoSon->name;
                $newDemoSon['icon']=$demoSon->icon;
                $newDemoSon['url']=$demoSon->url;
//                var_dump($newDemoSon);exit;
                $newDemo['items'][]=$newDemoSon;
            }
            $demoAll[]=$newDemo;
        }

        return $demoAll;
    }
}
