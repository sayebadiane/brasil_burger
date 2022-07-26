<?php
// api/src/Encoder/MultipartDecoder.php

namespace App\Encoder;

use App\Entity\Burger;
use App\Entity\Menu;
use App\Entity\Boisson;
use App\Entity\MenuBurger;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

final class Decoder implements DecoderInterface
{
    public const FORMAT = 'multipart';

    public function __construct(private RequestStack $requestStack)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function decode(string $data, string $format, array $context = []): ?array
    {
        $request = $this->requestStack->getCurrentRequest();
        // dd((json_decode($request->request->all()['menuBurgers'],true))['quantite']);
        // // dd($request);
        // if (!$request) {
        //     return null;
        // } 
        // $q=($request->request->get('menuBurgers'));
        // dd($request->request->all());
       $prix= $request->request->get("prix");
        $request->request->set("prix",floatval($prix));
       
    //   dd(($request->request->get('menuBurgers')->get('quantite')));
        
        return array_map(static function ( $element) {
            // Multipart form values will be encoded in JSON.
            $decoded = json_decode($element, true);
        //    dd($decoded);
            return \is_array($decoded) ? $decoded : $element;
        },$request->request->all()) + $request->files->all();
        
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDecoding(string $format): bool
    {
       
        return self::FORMAT === $format;
    }
     
}
