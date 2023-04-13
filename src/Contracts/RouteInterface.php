<?php

namespace EasyGithDev\PHPOpenAI\Contracts;

interface RouteInterface
{
    public function apiUrl(): string;
    public function audioTranscription(): string;
    public function audioTranslation(): string;
    public function chatCreate(): string;
    public function completionCreate(): string;
    public function editCreate(): string;
    public function embeddingCreate(): string;
    public function fileList(): string;
    public function fileCreate(): string;
    public function fileDelete($file_id): string;
    public function fileRetrieve($file_id): string;
    public function fileDownload($file_id): string;
    public function fineTuneList(): string;
    public function fineTuneCreate(): string;
    public function fineTunelistEvents($fine_tune_id): string;
    public function fineTuneRetrieve($fine_tune_id): string;
    public function fineTuneCancel($fine_tune_id): string;
    public function imageCreate(): string;
    public function imageCreateVariation(): string;
    public function imageCreateEdit(): string;
    public function modelList(): string;
    public function modelDelete($model_id): string;
    public function modelRetrieve($model_id): string;
    public function moderationCreate(): string;
}
