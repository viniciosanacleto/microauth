<?php


namespace common\utils;


use common\abstracts\Task;

class Response
{
    /**
     * Build a simple response
     * @param bool $status
     * @param $data
     * @return array
     */
    public static function build(bool $status, $data = null)
    {
        return [
            'success' => $status,
            'data' => $data
        ];
    }

    /**
     * Runs a task then build a response
     * @param Task $task
     * @return array
     */
    public static function buildFromTask(Task $task)
    {
        try {
            //Run the task
            $taskResponse = $task->run();
            //Mount the return
            return [
                'success' => true,
                'data' => $taskResponse
            ];
        } catch (\Exception $e) {
            //If task goes wrong
            return [
                'success' => false,
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Build a response based on result of a repository method
     * @param callable $repositoryMethod
     * @param array $params
     * @return array
     */
    public static function buildFromRepository(callable $repositoryMethod, $params = null)
    {
        $repositoryResponse = call_user_func($repositoryMethod, $params);

        if (!empty($repositoryResponse)) {
            return [
                'success' => true,
                'data' => $repositoryResponse
            ];
        }
        return [
            'success' => false,
            'data' => 'No results found!'
        ];
    }
}