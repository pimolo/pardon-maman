<?php

namespace AppBundle\Repository\Facebook;


use AppBundle\Entity\FacebookUser;
use Facebook\Facebook;

class PictureRepository
{
    const TYPE_UPLOADED = 'uploaded';
    const TYPE_TAGGED = 'tagged';

    /**
     * @var Facebook
     */
    private $sdk;

    public function __construct(Facebook $sdk)
    {
        $this->sdk = $sdk;
    }

    public function getAlbums(FacebookUser $user)
    {
        $response = $this->sdk->get('/me/albums', $user->getAccessToken())->getGraphEdge();

        return $response;
    }

    public function getPhotosByAlbum(FacebookUser $user, $albumId)
    {
        $response = $this->sdk->get('/' . $albumId . '/photos', $user->getAccessToken())->getGraphEdge();

        return $response;
    }

    public function getPicturesByUser(FacebookUser $user, $type = self::TYPE_UPLOADED)
    {
        $response = $this->sdk->get('/' . $user->getGraphUser()->getId() . '/photos?type=' . $type . '&fields=picture', $user->getAccessToken())->getGraphEdge();

        return $response;
    }

    public function getPictureById(FacebookUser $user, $id)
    {
        $response = $this->sdk->get('/' . $id . '?fields=picture', $user->getAccessToken())->getGraphNode();

        return $response;
    }
}
