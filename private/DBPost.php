<?php
/**
 * Created by Zhufyak V.V.
 * User: zhufy
 * E-mai: zhufyakvv@gmail.com
 * Git: https://github.com/zhufyakvv
 * Date: 30.04.2017
 * Time: 21:32
 * @param $data_base
 * @param $post
 * @param $class
 * @return mixed
 */
    function PostInsertDB($data_base, $post, $class){
        $object = (object)[];
        foreach ($post as $key => $value) {
            $object->$key = $value;
        }
        $entity = new $class($object);
        $entity->relate($data_base);
        $entity->insert();
        return $entity;
    }

    function PostUpdateDB($data_base, $post, $entity){
        $entity->relate($data_base);
        foreach ($post as $key => $value){
            if ($key != "id") {
                $entity->update($key, $value);
            }
        }
        return $entity;
    }
?>

