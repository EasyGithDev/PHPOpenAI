<?php

namespace EasyGithDev\PHPOpenAI;

use EasyGithDev\PHPOpenAI\Contracts\RouteInterface;

/**
 * This class allows the management of the URL
 * and access to the different entry points of the API.
 */
class OpenAIRoute implements RouteInterface
{
    /**
     * The API url
     * @var string
     */
    protected string $apiUrl = '';

    /**
     * @param string|null protected $origin
     * @param string|null protected $version
     */
    public function __construct(protected ?string $origin = null, protected ?string $version = null)
    {
        $this->origin = $origin ?? 'https://api.openai.com';
        $this->version = $servion ?? 'v1';
        $this->apiUrl = $this->origin . '/' . $this->version;
    }

    /**
     * Get the value of apiUrl
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * Set the value of apiUrl
     *
     * @param string $apiUrl
     *
     * @return self
     */
    public function setApiUrl(string $apiUrl): self
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    /**
     * Get the audio transcription url
     * @return string
     */
    public function audioTranscription(): string
    {
        return $this->apiUrl . '/audio/transcriptions';
    }

    /**
     * Get the audio translation url
     * @return string
     */
    public function audioTranslation(): string
    {
        return $this->apiUrl . '/audio/translations';
    }

    /**
     * Get the chat url
     * @return string
     */
    public function chatCreate(): string
    {
        return $this->apiUrl . '/chat/completions';
    }

    /**
     * Get the completion url
     * @return string
     */
    public function completionCreate(): string
    {
        return $this->apiUrl . '/completions';
    }

    /**
     * Get the edit url
     * @return string
     */
    public function editCreate(): string
    {
        return $this->apiUrl . '/edits';
    }

    /**
     * Get the embedding url
     * @return string
     */
    public function embeddingCreate(): string
    {
        return $this->apiUrl . '/embeddings';
    }

    /**
     * Get the file list url
     * @return string
     */
    public function fileList(): string
    {
        return $this->apiUrl . '/files';
    }

    /**
     * Get the file create url
     * @return string
     */
    public function fileCreate(): string
    {
        return $this->apiUrl . '/files';
    }

    /**
     * Get the file delete url
     * @return string
     */
    public function fileDelete($file_id): string
    {
        return $this->apiUrl . '/files/' . $file_id;
    }

    /**
     * Get the file retrieve url
     * @return string
     */ public function fileRetrieve($file_id): string
    {
        return $this->apiUrl . '/files/' . $file_id;
    }

    /**
     * Get the file download url
     * @return string
     */
    public function fileDownload($file_id): string
    {
        return $this->apiUrl . '/files/' . $file_id . '/content';
    }

    /**
     * Get the fine tune list url
     * @return string
     */
    public function fineTuneList(): string
    {
        return $this->apiUrl . '/fine-tunes';
    }

    /**
     * Get the fine tune create url
     * @return string
     */

    public function fineTuneCreate(): string
    {
        return $this->apiUrl . '/fine-tunes';
    }

    /**
     * Get the fine tune list events url
     * @return string
     */

    public function fineTunelistEvents($fine_tune_id): string
    {
        return $this->apiUrl . '/fine-tunes/' . $fine_tune_id . '/events';
    }

    /**
     * Get the fine tune retrieve url
     * @return string
     */

    public function fineTuneRetrieve($fine_tune_id): string
    {
        return $this->apiUrl . '/fine-tunes/' . $fine_tune_id;
    }

    /**
     * Get the fine tune cancel url
     * @return string
     */

    public function fineTuneCancel($fine_tune_id): string
    {
        return $this->apiUrl . '/fine-tunes/' . $fine_tune_id . '/cancel';
    }

    /**
     * Get the image create url
     * @return string
     */
    public function imageCreate(): string
    {
        return $this->apiUrl . '/images/generations';
    }

    /**
     * Get the image variation url
     * @return string
     */
    public function imageCreateVariation(): string
    {
        return $this->apiUrl . '/images/variations';
    }

    /**
     * Get the image edit url
     * @return string
     */
    public function imageCreateEdit(): string
    {
        return $this->apiUrl . '/images/edits';
    }

    /**
     * Get the model list url
     * @return string
     */
    public function modelList(): string
    {
        return $this->apiUrl . '/models';
    }

    /**
     * Get the model delete url
     * @return string
     */
    public function modelDelete($model_id): string
    {
        return $this->apiUrl . '/models/' . $model_id;
    }

    /**
     * Get the model retrieve url
     * @return string
     */
    public function modelRetrieve($model_id): string
    {
        return $this->apiUrl . '/models/' . $model_id;
    }

    /**
     * Get the moderation create url
     * @return string
     */
    public function moderationCreate(): string
    {
        return $this->apiUrl . '/moderations';
    }
}
