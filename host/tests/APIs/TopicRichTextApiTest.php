<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\TopicRichText;

class TopicRichTextApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_topic_rich_text()
    {
        $topicRichText = TopicRichText::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/topic_rich_texts', $topicRichText
        );

        $this->assertApiResponse($topicRichText);
    }

    /**
     * @test
     */
    public function test_read_topic_rich_text()
    {
        $topicRichText = TopicRichText::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/topic_rich_texts/'.$topicRichText->id
        );

        $this->assertApiResponse($topicRichText->toArray());
    }

    /**
     * @test
     */
    public function test_update_topic_rich_text()
    {
        $topicRichText = TopicRichText::factory()->create();
        $editedTopicRichText = TopicRichText::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/topic_rich_texts/'.$topicRichText->id,
            $editedTopicRichText
        );

        $this->assertApiResponse($editedTopicRichText);
    }

    /**
     * @test
     */
    public function test_delete_topic_rich_text()
    {
        $topicRichText = TopicRichText::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/topic_rich_texts/'.$topicRichText->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/topic_rich_texts/'.$topicRichText->id
        );

        $this->response->assertStatus(404);
    }
}
