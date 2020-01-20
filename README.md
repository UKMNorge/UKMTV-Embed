UKMTV-Embed
===========

Når UKM-TV embeddes fra et sted, er det dette repoet som svarer (vanligvis fra https://embed.ukm.no). Selv UKM-TV benytter en iframe som peker hit, og det samme gjør naturlig nok også oembed-lenkene våre.

**index.php**
Index.php viser html-GUI'et. Javascriptet som setter opp JWPlayer inkluderes via /info/`film_id`/ (som via .htaccess peker til `config.php`). 
Dette gjør at samme person får samme cache over en liten periode, slik at en evt refresh av siden ikke sender deg til en ny cache, som krever en full reload. Det er kostbart både for oss og brukeren.

**config.php** 
Her setter vi opp JWPlayer med config til wowza basert på gitt ID.