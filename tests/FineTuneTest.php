<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Validators\ValidatorBuilder;
use PHPUnit\Framework\TestCase;

final class FineTuneTest extends TestCase
{

    // public function testList()
    // {
    //     $handler =  (new OpenAIClient(getenv('OPENAI_API_KEY')))
    //         ->FineTune()
    //         ->list();

    //     $response = $handler->getResponse();
    //     $contentTypeValidator = $handler->getContentTypeValidator();

    //     $this->assertEquals(true, ValidatorBuilder::create('status', $response)->validate());
    //     $this->assertEquals(true, ValidatorBuilder::create($contentTypeValidator, $response)->validate());
    // }

    // public function testCreate()
    // {
    //     $file_id = (new OpenAIClient(getenv('OPENAI_API_KEY')))
    //         ->File()
    //         ->create(
    //             __DIR__ . '/../assets/mydata.jsonl',
    //             'fine-tune',
    //         )->toObject()->id;

    //     $handler =  (new OpenAIClient(getenv('OPENAI_API_KEY')))
    //         ->FineTune()
    //         ->create($file_id);

    //     $response = $handler->getResponse();
    //     $contentTypeValidator = $handler->getContentTypeValidator();

    //     $this->assertEquals(true, ValidatorBuilder::create('status', $response)->validate());
    //     $this->assertEquals(true, ValidatorBuilder::create($contentTypeValidator, $response)->validate());
    //     return json_decode($response)->id;
    // }

    // /**
    //  * @depends testCreate
    //  */
    // public function testRetrieve($fine_tune_id)
    // {
    //     $this->assertStringStartsWith('ft-', $fine_tune_id);
    //     $handler =  (new OpenAIClient(getenv('OPENAI_API_KEY')))
    //         ->FineTune()
    //         ->retrieve($fine_tune_id);

    //     $response = $handler->getResponse();
    //     $contentTypeValidator = $handler->getContentTypeValidator();

    //     $this->assertEquals(true, ValidatorBuilder::create('status', $response)->validate());
    //     $this->assertEquals(true, ValidatorBuilder::create($contentTypeValidator, $response)->validate());
    //     return $fine_tune_id;
    // }

    // /**
    //  * @depends testRetrieve
    //  */
    // public function testListEvents($fine_tune_id)
    // {
    //     $this->assertStringStartsWith('ft-', $fine_tune_id);
    //     $handler =  (new OpenAIClient(getenv('OPENAI_API_KEY')))
    //         ->FineTune()
    //         ->listEvents($fine_tune_id);

    //     $response = $handler->getResponse();
    //     $contentTypeValidator = $handler->getContentTypeValidator();

    //     $this->assertEquals(true, ValidatorBuilder::create('status', $response)->validate());
    //     $this->assertEquals(true, ValidatorBuilder::create($contentTypeValidator, $response)->validate());
    //     return $fine_tune_id;
    // }

    // /**
    //  * @depends testRetrieve
    //  */
    // public function testCancel($fine_tune_id)
    // {
    //     $this->assertStringStartsWith('ft-', $fine_tune_id);
    //     $handler =  (new OpenAIClient(getenv('OPENAI_API_KEY')))
    //         ->FineTune()
    //         ->cancel($fine_tune_id);

    //     $response = $handler->getResponse();
    //     $contentTypeValidator = $handler->getContentTypeValidator();

    //     $this->assertEquals(true, ValidatorBuilder::create('status', $response)->validate());
    //     $this->assertEquals(true, ValidatorBuilder::create($contentTypeValidator, $response)->validate());
    //     return $fine_tune_id;
    // }
}
