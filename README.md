<h1>CRM muita (iedvesmots no DHL paciņu piegādes mājaslapas :D )</h1>
<h2>Ja jūs vēlaties šo projektu palaist lokāli (nekas dižs tur nav..) tad es to darītu ar komandām šādi:</h2>
<p>pēc projekta ieklonēšanas izpildiet <b>composer install</b></p>
<p>izmainiet .env failā lai datubāze izmanotu mysql - "DB_CONNECTION=mysql" un  "DB_DATABASE=webmuita"</p>
<p>terminālī izpildieet komandu <b>php artisan key:generate</b></p>
<p>terminālī izpildiet komandu <b>php artisan migrate</b></p>
<p>tākā projektā tiek izmantoti dati no DB jāizpilda <i>stilīga</i> komanda <b>php artisan api</b> , kura piepildīs DB ar datiem no api (aizņm kādas 3min....)</p>
<p>kad terminālis atkal sākdarboties izpildiet <b>php artisan serve</b></p>
