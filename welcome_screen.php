<!-- start -->
<!-- GR: Σελίδα καλωσορίσματος; DE: Willkommensseite; AT: Willkommensseite; CY: Σελίδα καλωσορίσματος; CH: Pagina Salutationis; ES: Página de bienvenida; MX: Página de bienvenida; FR: Page d'accueil; BE: Page d'accueil; TR: Hoş Geldiniz Sayfası; IT: Pagină de bun venit; RO: Accesibilitate; MD: Pagină de bun venit; LK: स्वागत पृष्ठ; IN: स्वागत पृष्ठ; RU: Страница приветствия; RS: Добродошла страница; NP: དགའ་བསུ་ཞུ།; BR: Página de boas-vindas; PT: Página de boas-vindas; UA: Сторінка привітання; CN: 欢迎页面; KR: 환영 페이지; JP: ようこそページ; AE: صفحة الترحيب; SA: صفحة الترحيب; IQ: صفحة الترحيب; IR: صفحة الترحيب; KW: صفحة الترحيب; QA: صفحة الترحيب -->
<!-- main_menu -->
<div class='customPanel' style="width:100%;">
    <p align="center">
        <img onmouseover="soundButton();" id="showingAvatarNow" name="main_menu" style="height:24%;" onclick="omniGo(this.name);" src="<?=$prefix[0].$session['avatar'].'.png';?>">
        <h1 id="articleHead" align='center' style="cursor:pointer;" onclick="clip(this.innerText);"></h1>
    </p>
</div>
<div class='customPanel' style="width:100%;height:50%;overflow-y:scroll;">
    <p id="articleBody" align="center" style="cursot:pointer;" onclick="clip(this.innerText);"></p>
    <p align="center"><a id="articleLink"></a></p>
</div>
