<!-- appstore -->
<!-- AD: Tienda de software; AG: Tienda de software; AR: Tienda de software; AT: Software-Shop; BE: Boutique de logiciels; BR: Loja de software; CH: Taberna applicationum; CL: Tienda de software; CN: 应用商店; CO: Tienda de software; CU: Tienda de software; CY: Προγράμματα; DD: Software-Shop; DE: Software-Shop; DR: Software-Shop; ES: Tienda de software; FR: Boutique de logiciels; GR: Προγράμματα; IN: सॉफ्टवेयर स्टोर; IT: Negozio di software; JP: アプリストア; KP: 앱 스토어; KR: 앱 스토어; LK: सॉफ्टवेयर स्टोर; MC: Boutique de logiciels; MD: Magazin de software; MX: Tienda de software; PT: Loja de software; RO: Magazin de software; RU: Магазин приложений; SM: Negozio di software; SP: Taberna applicationum; TR: Yazılım Mağazası; UA: Магазин додатків; VA: Taberna applicationum -->
<table style="width:100%;" id="table" class="wrapper">
    <thead>
        <tr>
            <th style="width:8%;">
                <?=term('Icon', $settings, $session);?>
            </th>
            <th style="width:60%;">
                <a href="javascript:SortTable(1,'T');">
                    <?=term('URL', $settings, $session);?>
                </a>
            </th>
            <th style="width:32%;">
                <?=term('Actions', $settings, $session);?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $iconSize = 30;
        $entryIcon = $themePrefix . 'appstore.webp';

        foreach ($settings['payload'][$request['mode']] as $key => $channel) {
            // Получаем ID пакета из основного URI репозитория (для проверки наличия .package.json)
            $uriPart = parse_url($key);
            $pkgID = array_reverse(explode('/', $uriPart['path']))[0];
            $hasPackageJson = file_exists($pkgID . '.package.json');
            ?>
            <tr>
                <!-- Колонка 1: иконка репозитория -->
                <td>
                    <a href="<?=$entryIcon;?>">
                        <img style="width:<?=$iconSize;?>px;" src="<?=$entryIcon;?>" loading="lazy" onmouseover="soundButton();" alt="Repo icon">
                    </a>
                </td>

                <!-- Колонка 2: подтаблица с зеркалами и кнопкой "Обновить" -->
                <td>
                    <table style="width:100%; border-collapse: collapse;">
                        <!-- Строка основного репозитория -->
                        <tr style="border-bottom: 1px solid #ccc;">
                            <td style="width:5%; padding:4px;">
                                <img style="width:<?=$iconSize;?>px;" src="<?=$themePrefix . 'package.webp';?>" loading="lazy" alt="Package">
                            </td>
                            <td style="padding:4px;">
                                <a href="javascript:clip('<?=$key;?>');"><?=$key;?></a>
                            </td>
                            <td style="width:20%; padding:4px; text-align:right;">
                                <input type="image" name="<?=$key;?>" onmouseover="soundButton();" class="power"
                                       onclick="getPkgSequence('get -i '+this.name,'get ',0);"
                                       src="<?=$prefix[3] . 'update.webp';?>" alt="Update">
                            </td>
                        </tr>

                        <!-- Зеркала -->
                        <?php foreach ($channel as $uri => $uris) {
                            foreach ($uris as $mirror) {
                                $mirrorUriPart = parse_url($mirror);
                                $mirrorID = array_reverse(explode('/', $mirrorUriPart['path']))[0];
                                ?>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td style="width:5%; padding:4px;">
                                        <img style="width:<?=$iconSize;?>px;" src="<?=$themePrefix . 'link.webp';?>" loading="lazy" alt="Mirror">
                                    </td>
                                    <td style="padding:4px;">
                                        <a href="javascript:clip('<?=$mirror;?>');"><?=$mirror;?></a>
                                    </td>
                                    <td style="width:20%; padding:4px; text-align:right;">
                                        <input type="image" name="<?=$mirror;?>" onmouseover="soundButton();" class="power"
                                               onclick="getPkgSequence('get -i '+this.name,'get ');"
                                               src="<?=$prefix[3] . 'update.webp';?>" alt="Update mirror">
                                    </td>
                                </tr>
                                <?php
                            }
                        } ?>
                    </table>
                </td>

                <!-- Колонка 3: кнопка "Удалить" только для основного репозитория -->
                <td style="vertical-align: top; padding-top: 8px;">
                    <?php if ($hasPackageJson): ?>
                        <input type="image" name="<?=$pkgID;?>" onmouseover="soundButton();" class="power"
                               onclick="getPkgSequence('get -d '+this.name,'get ');"
                               src="<?=$prefix[3] . 'trash.webp';?>" alt="Delete">
                    <?php endif; ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
