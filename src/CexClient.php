<?php declare(strict_types=1);

namespace Liamja\Cex;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use JsonMapper;
use function GuzzleHttp\json_decode;

/**
 * CeX API Client.
 */
class CexClient
{
    /**
     * HTTP Client.
     *
     * @var ClientInterface
     */
    private $client;

    /**
     * JSON Mapper.
     *
     * @var JsonMapper
     */
    private $mapper;

    /**
     * CeX constructor.
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client = null)
    {
        $this->client = $client ?? new \GuzzleHttp\Client([
                'base_uri' => 'https://wss2.cex.uk.webuy.io/v3/',
            ]);

        $this->mapper = new JsonMapper();
    }

    /**
     * Get the stores closest to a latitude and longitude.
     *
     * curl -XGET 'https://wss2.cex.uk.webuy.io/v3/boxes/5030305620561/neareststores?latitude=52.62343240000001&longitude=1.3077290999999605'
     *
     * @param float $latitude
     * @param float $longitude
     *
     * @return NearestStore[]
     */
    public function searchNearestStores(float $latitude, float $longitude)
    {
        $response = $this->client->get('stores/nearest', [
            RequestOptions::QUERY => [
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]
        ]);

        $jsonResponse = json_decode($response->getBody());

        $output = $this->mapper->mapArray(
            $jsonResponse->response->data->nearestStores, [], NearestStore::class
        );

        return $output;
    }

    /**
     * Search for Boxes.
     *
     * curl -XGET 'https://wss2.cex.uk.webuy.io/v3/boxes?q=ashes%20to%20ashes'
     *
     * @param SearchParameters $searchParameters
     *
     * @return Box[]
     */
    public function searchBoxes(SearchParameters $searchParameters): array
    {
        $response = $this->client->get('boxes', [
            RequestOptions::QUERY => $searchParameters->getPreparedParameters(),
        ]);

        $jsonResponse = json_decode($response->getBody());

        $output = $this->mapper->mapArray(
            $jsonResponse->response->data->boxes, [], Box::class
        );

        return $output;
    }

    /**
     * Predictive Search for Boxes.
     *
     * curl -XGET 'https://wss2.cex.uk.webuy.io/v3/boxes/predictivesearch?q=ashes%20to%20ashes'
     *
     * @param SearchParameters $searchParameters
     *
     * @return Box[]
     */
    public function predictiveSearch(SearchParameters $searchParameters): array
    {
        $response = $this->client->get('boxes/predictivesearch', [
            RequestOptions::QUERY => $searchParameters->getPreparedParameters(),
        ]);

        $jsonResponse = json_decode($response->getBody());

        $output = $this->mapper->mapArray(
            $jsonResponse->response->data->results, [], PredictiveSearchResult::class
        );

        return $output;
    }
}
