<?php


namespace common\abstracts;

use Illuminate\Database\Eloquent\Model;

class Repository
{
    /** @var Model $model */
    protected $model;

    /**
     * Private method to check if $model is set
     * @param $functionName
     * @throws \Exception
     */
    private function checkModel($functionName){
        if(empty($this->model) || $this->model == null){
            throw new \Exception('The method '.$functionName.'() cannot be used if model is not set. [protected $model]');
        }
    }

    /**
     * Get the row that matches the id
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    final public function getById($id){
        self::checkModel(__FUNCTION__);
        return $this->model::find($id);
    }

    /**
     *Get all rows ordered asc. If limited, get first $limit rows
     * @param null $limit
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     * @throws \Exception
     */
    final public function getAll($limit = null){
        self::checkModel(__FUNCTION__);
        return $this->model::take($limit)->get();
    }

    /**
     * Create new row
     * @param array $form
     * @throws \Exception
     */
    final public function create(array $form){
        self::checkModel(__FUNCTION__);
        $this->model::create($form);
    }

    /**
     * Update a row by id
     * @param $id
     * @param $form
     * @throws \Exception
     */
    final public function update($id, $form){
        self::checkModel(__FUNCTION__);
        $modelInstance = self::getById($id);
        if(!empty($modelInstance)){
            $modelInstance->update($form);
        }
        else{
            throw new \Exception('Cannot find the id #'.$id,$id);
        }
    }

    /**
     * Delete a row by id
     * @param $id
     * @throws \Exception
     */
    final public function delete($id){
        self::checkModel(__FUNCTION__);
        $modelInstance = self::getById($id);
        if(!empty($modelInstance)){
            $modelInstance->delete();
        }
        else{
            throw new \Exception('Cannot find the id #'.$id,$id);
        }
    }
}