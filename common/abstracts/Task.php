<?php


namespace common\abstracts;


abstract class Task
{
    /**
     * Main method. Implement the business rule
     * @return mixed
     * @throws \Exception
     */
    abstract protected function handle();

    /**
     *Runs before the handle()
     */
    protected function before(){}

    /**
     *Runs after the handle()
     */
    protected function after(){}

    /**
     * Run the lifecycle methods
     * @return mixed
     * @throws \Exception
     */
    final public function run(){
        $this->before();
        $handleResult = $this->handle();
        $this->after();
        return $handleResult;
    }
}
