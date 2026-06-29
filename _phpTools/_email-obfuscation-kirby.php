<?php

/**
 * Obfuscation des adresses email
 *
 * Remplace chaque adresse email en texte brut par un marqueur :
 *
 *     adresse@exemple.com   ->   :::decode YWRyZXNzZUBleGVtcGxlLmNvbQ==:::
 *
 * Le front décode ces marqueurs (voir code dans le fichier decodeObfuscatedHTML.ts dans le front)
 * (decodeEncodedBlocks fait un atob() sur le contenu base64).
 *
 * Important : pas d'espace AVANT ":::" final — le base64 est suivi directement
 * de ":::", sinon atob() recevrait un espace parasite.
 */

function obfuscateEmails(string $stringWithMailAdresses): ?string
{
    return preg_replace_callback(
        '/[A-Za-z0-9._%+\-]+@[A-Za-z0-9.\-]+\.[A-Za-z]{2,}/',
        fn (array $m): string => ':::decode ' . base64_encode($m[0]) . ':::',
        $stringWithMailAdresses
    );

}
