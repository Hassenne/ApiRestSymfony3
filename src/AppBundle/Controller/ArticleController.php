<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 05/07/2018
 * Time: 14:57
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Article;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\RestBundle\Request\ParamFetcherInterface;
use AppBundle\Representation\Articles;




class ArticleController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/articles/{id}",
     *     name = "app_article_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View()
     */
    public function showAction(Article $article)
    {
        return $article;
    }

    /**

     * @Rest\Post(

     *    path = "/articles",

     *    name = "app_article_create"

     * )

     * @Rest\View(StatusCode = 201)

     * @ParamConverter("article", converter="fos_rest.request_body")

     */

    public function createAction(Article $article)

    {

        $em = $this->getDoctrine()->getManager();


        $em->persist($article);

        $em->flush();



        return $this->view($article, Response::HTTP_CREATED, ['Location' => $this->generateUrl('app_article_show', ['id' => $article->getId(), UrlGeneratorInterface::ABSOLUTE_URL])]);

    }

    /**
     * @Rest\Get("/articles", name="app_article_list")
     * @Rest\QueryParam(
     *     name="keyword",
     *     requirements="[a-zA-Z0-9]",
     *     nullable=true,
     *     description="The keyword to search for."
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="15",
     *     description="Max number of article per page."
     * )
     * @Rest\QueryParam(
     *     name="offset",
     *     requirements="\d+",
     *     default="1",
     *     description="The pagination offset"
     * )
     * @Rest\View(
     *
     * )
     *
     * @param ParamFetcherInterface $paramFetcher
     * @return mixed
     */
    public function listAction(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->getDoctrine()->getRepository('AppBundle:Article')->search(
            $paramFetcher->get('keyword'),
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('offset')
        );
        return new Articles($pager);
    }

}