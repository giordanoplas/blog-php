<?php require 'views/header.php'; ?> 

    <div class="contenedor">        
        <?php foreach($articulos as $articulo): ?>            
            <div class="post">
                <article>
                    <h2 class="titulo"><a href="single.php?id=<?php echo $articulo['id']; ?>"><?php echo $articulo['titulo']; ?></a></h2>
                    <p class="fecha"><?php echo fecha($articulo['fecha']); ?></p>
                    <div class="thumb">
                        <a href="single.php?id=<?php echo $articulo['id']; ?>">
                            <img src="<?php echo RUTA; ?>imagenes/<?php echo $articulo['thumb']; ?>" alt="">
                        </a>
                    </div>
                    <p class="extracto"><?php echo $articulo['extracto']; ?></p>
                    <a href="single.php?id=<?php echo $articulo['id']; ?>" class="continuar">Continuar Leyendo</a>
                </article>
            </div>
        <?php endforeach; ?>         

        <?php require 'paginacion.php'; ?>

<?php require 'views/footer.php'; ?>