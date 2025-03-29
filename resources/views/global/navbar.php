<aside class="open">
        <ul>
            <li class="header-aside">
                <img src="<?= URL::to("assets/images/logos/Logo-background-gris-oscuro.png") ?>" alt="">
                <div>
                    <h5>Linamar</h5>
                    <span>Detalles personalizados</span>
                </div>
            </li>
            <hr class="horizontal dark mt-0">

            <?php foreach ($menuItems as $section => $item):?>
                
                <!-- SECCIONES -->
                <li>
                    <div><?= $section ?></div>
                </li>

                <!-- ITEMS DENTRO DE CADA SECCIÓN -->
                <?php foreach ($item as $key => $value):?>
                    <li class="<?= $key == $activeItem ? "active" : "" ?>">
                        <a href="<?= $key == $activeItem ? "#" : URL::to($value["Uri"]) ?>">
                            <span class="material-symbols-rounded">
                                <?= $value["Icon"] ?>
                            </span>
                            <div><?= $key ?></div>
                        </a>
                    </li>
                <?php endforeach; ?>

            <?php endforeach; ?>
            

        </ul>
    </aside>