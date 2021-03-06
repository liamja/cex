<?php declare(strict_types=1);

namespace Liamja\Cex\Tests;

use DateTimeImmutable;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Liamja\Cex\CexClient;
use Liamja\Cex\FailureException;
use Liamja\Cex\Models\Box;
use Liamja\Cex\Models\NearestStore;
use Liamja\Cex\Models\PredictiveSearchResult;
use Liamja\Cex\Models\Store;
use Liamja\Cex\SearchParameters;

class CexClientTest extends \PHPUnit\Framework\TestCase
{
    public static function createMockCexClient(array $fixtures): CexClient
    {
        $responses = [];

        foreach ($fixtures as $fixture) {
            $fixtureFilePath = __DIR__ . '/fixtures/' . $fixture[1];
            $fixtureContents = file_get_contents($fixtureFilePath);

            if ($fixtureContents == false) {
                throw new \RuntimeException("Can't read {$fixtureFilePath}");
            }

            $responses[] = new Response(
                $fixture[0],
                [
                    'Content-Type' => 'application/json; charset=UTF-8',
                    'Vary' => 'Accept-Encoding',
                    'Content-Encoding' => 'br',
                    'Date' => (new DateTimeImmutable('UTC'))->format('D, d M Y H:i:s \G\M\T'),
                    'Access-Control-Allow-Origin' => 'https://uk.webuy.com',
                    'Strict-Transport-Security' => 'max-age=15552000',

                ],
                $fixtureContents
            );
        }

        return new CexClient(new Client([
            'base_uri' => 'https://wss2.cex.uk.webuy.io/v3/',
            'handler' => HandlerStack::create(new MockHandler(
                $responses
            ))
        ]));
    }

    public function testSearchBoxesReturnsArrayOfBoxObjects(): void
    {
        $cex = static::createMockCexClient([[200, 'Boxes/SuperMarioBrosBoxes.json']]);

        $searchParameters = new SearchParameters();
        $searchParameters->setSearchTerm('Super Mario Bros');

        $boxes = $cex->searchBoxes($searchParameters);

        $this->assertInstanceOf(Box::class, $boxes[0]);
    }

    public function testGetStoresReturnsArrayOfStoreObjects(): void
    {
        $cex = static::createMockCexClient([[200, 'Stores/Stores.json']]);

        $stores = $cex->getStores();

        $this->assertInstanceOf(Store::class, $stores[0]);
    }

    public function testSearchNearestStoresReturnsArrayOfNearestStoreObjects(): void
    {
        $cex = static::createMockCexClient([[200, 'NearestStores/Norwich.json']]);

        $stores = $cex->searchNearestStores(1.2973550000000387, 52.6308859);

        $this->assertInstanceOf(NearestStore::class, $stores[0]);
    }

    public function testPredictiveSearchReturnsArrayOfPredictiveSearchResultObjects(): void
    {
        $cex = static::createMockCexClient([[200, 'PredictiveSearch/SuperMarioBrosPredictiveSearchResults.json']]);

        $searchParameters = new SearchParameters();
        $searchParameters->setSearchTerm('Super Mario Bros');

        $results = $cex->predictiveSearch($searchParameters);

        $this->assertInstanceOf(PredictiveSearchResult::class, $results[0]);
    }

    public function testPredictiveSearchThrowsFailureExceptionWhenSearchTextIsMissing(): void
    {
        $this->expectException(FailureException::class);

        $cex = static::createMockCexClient([[400, 'PredictiveSearch/MissingSearchText.json']]);

        // Cause an exception by not setting the search term on SearchParameters.
        $cex->predictiveSearch(new SearchParameters());
    }
}
