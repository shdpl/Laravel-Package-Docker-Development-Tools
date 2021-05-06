<?php namespace Tests\Repositories;

use App\Models\TopicRichText;
use App\Repositories\TopicRichTextRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TopicRichTextRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TopicRichTextRepository
     */
    protected $topicRichTextRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->topicRichTextRepo = \App::make(TopicRichTextRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_topic_rich_text()
    {
        $topicRichText = TopicRichText::factory()->make()->toArray();

        $createdTopicRichText = $this->topicRichTextRepo->create($topicRichText);

        $createdTopicRichText = $createdTopicRichText->toArray();
        $this->assertArrayHasKey('id', $createdTopicRichText);
        $this->assertNotNull($createdTopicRichText['id'], 'Created TopicRichText must have id specified');
        $this->assertNotNull(TopicRichText::find($createdTopicRichText['id']), 'TopicRichText with given id must be in DB');
        $this->assertModelData($topicRichText, $createdTopicRichText);
    }

    /**
     * @test read
     */
    public function test_read_topic_rich_text()
    {
        $topicRichText = TopicRichText::factory()->create();

        $dbTopicRichText = $this->topicRichTextRepo->find($topicRichText->id);

        $dbTopicRichText = $dbTopicRichText->toArray();
        $this->assertModelData($topicRichText->toArray(), $dbTopicRichText);
    }

    /**
     * @test update
     */
    public function test_update_topic_rich_text()
    {
        $topicRichText = TopicRichText::factory()->create();
        $fakeTopicRichText = TopicRichText::factory()->make()->toArray();

        $updatedTopicRichText = $this->topicRichTextRepo->update($fakeTopicRichText, $topicRichText->id);

        $this->assertModelData($fakeTopicRichText, $updatedTopicRichText->toArray());
        $dbTopicRichText = $this->topicRichTextRepo->find($topicRichText->id);
        $this->assertModelData($fakeTopicRichText, $dbTopicRichText->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_topic_rich_text()
    {
        $topicRichText = TopicRichText::factory()->create();

        $resp = $this->topicRichTextRepo->delete($topicRichText->id);

        $this->assertTrue($resp);
        $this->assertNull(TopicRichText::find($topicRichText->id), 'TopicRichText should not exist in DB');
    }
}
