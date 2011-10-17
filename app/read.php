<div id="book"></div>

<script id="book-cover" type="text/x-jquery-tmpl">
	<div class="book-cover"></div>
</script>

<script id="book-inside" type="text/x-jquery-tmpl">
	<div class="book-inside">
		<div class="left-page">
			<!--<h1>${code}</h1>-->
			<h1 class="code">XVII</h1>
			<!--<p class="image">${image}</p>-->
			<!--<p class="exposition">${exposition}</p>-->
			<p class="exposition">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		</div>
		<div class="right-page">
			<!--<p class="label">${label}</p>-->
			<p class="label">Que décidez-vous ?</p>
			<p class="choix">
				{{each choix}}
			        <input type="radio" name="choix" value="${$value}" />
			    {{/each}}
			</p>
		</div>
	</div>
</script>

<script id="book-back" type="text/x-jquery-tmpl">
	<div class="book-back">
		<h1>${title}</h1>
		<h2>${sub_title}</h2>
		<h3>Auteurs</h3>
		<ul>
			{{each authors}}
				<li>${value}</li>
			{{/each}}
		</ul>
		<h3>Librairies et ressources utilisées</h3>
		<ul>
			{{each links}}
				<li>
					<a href="${$value.link}">${$value.name}</a>
				</li>
			{{/each}}
			<!--<li><a href="http://jquery.com/">jQuery</a></li>
			<li><a href="http://api.jquery.com/jquery.tmpl/">jQuery templates</a></li>
			<li><a href="http://letteringjs.com/">Lettering.js</a></li>
			<li><a href="http://lesscss.org/">LESS</a></li>
			<li><a href="http://beyond-oddities.deviantart.com/art/Local-Texture-Three-by-One-77137822">Wood texture by Beyond-Oddities</a></li>
			<li><a href="http://www.bittbox.com/freebies/free-high-res-texture-pack-the-anatomy-of-a-really-old-book">Book textures by Jay Hilgert</a></li>
			<li><a href="http://www.dafont.com/fr/hilda-sonnenschein.font">Police Hilda Sonnenschein</a></li>
			<li><a href="http://www.google.com/webfonts/specimen/Rochester">Police Rochester</a></li>-->
		</ul>
	</div>
</script>