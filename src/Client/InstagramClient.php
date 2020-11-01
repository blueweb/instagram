<?php declare(strict_types=1);

namespace Blueweb\Instagram\Client;

use Blueweb\Instagram\Exception\Runtime\RequestException;
use Blueweb\Instagram\Exception\Runtime\ResponseException;
use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Nette\Utils\Json;

class InstagramClient
{

	/** @var string */
	protected $apiKey;

	/** @var string */
	protected $refreshTokenFeedUrl;

	public function __construct(string $apiKey)
	{
		$this->apiKey = $apiKey;

		$this->refreshTokenFeedUrl = 'https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=' . $this->apiKey;
		$this->instagramFeedUrl = 'https://graph.instagram.com/me/media?fields=id,caption,media_type,permalink,thumbnail_url,timestamp,username&access_token=' . $this->apiKey;
	}

	protected function checkValidResponse(): void
	{
		$refreshAccessTokenFeed = @file_get_contents($this->refreshTokenFeedUrl);

		if ($refreshAccessTokenFeed === false) {
			throw new RequestException('Something went wrong with instagram feed. ' . $this->refreshTokenFeedUrl);
		}

		$instagramFeed = @file_get_contents($this->instagramFeedUrl);

		if ($refreshAccessTokenFeed === false) {
			throw new RequestException('Something went wrong with instagram feed. ' . $this->instagramFeedUrl);
		}
	}

	public function fetchData(): array
	{
		$this->checkValidResponse();

		$instagramFeed = @file_get_contents($this->instagramFeedUrl);
		$data = [];

		next:
		$rawData = Json::decode($instagramFeed);

		$data[] = $rawData->data;

		if (isset($rawData->paging->next)) {
			$next = @file_get_contents($rawData->paging->next);
			$instagramFeed = $next;
			goto next;
		}

		return $data;

	}

}