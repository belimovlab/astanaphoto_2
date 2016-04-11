     
    </section>
    <footer>
        <div class="container_15">
            <div class="grid_15 footer">
                
                <a href="<?php echo base_url('/about')?>">О проекте</a>
                <a href="<?php echo base_url('/terms')?>">Условия использования</a>
                <a href="<?php echo base_url('/feedback')?>">Обратная связь</a>
                <a href="<?php echo base_url('/support')?>">Техподдержка</a>
                &copy; <?php echo date('Y');?>
            </div>
        </div>
    </footer>
    <?php foreach($js as $one):?>
        <?php if($one):?>
            <script src="/assets/js/<?php echo $one?>.js"></script>
        <?php endif;?>
    <?php endforeach;?>
</body>
</html>