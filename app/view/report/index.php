<div class="container" id="report-list">
    <div class="row">
        <div class="col-12">
            <h1>I REPORT</h1>
        </div>
    </div>
    <?php foreach($reports as $report){ ?>
    <div class="row">

            <div class="col-12">
                <h2>
                    <a href="/report/view/<?php echo $report->id; ?>"><?php echo $report->titolo; ?></a>
                </h2>
            </div>
            <div class="col-9">
                <span class="report-date"><?php echo strftime('%d/%m/%Y', $report->mod_date);?></span> | <span class="report-author"></span>
                <hr />
                <p class="report-description"><?php echo hellip($report->descrizione, 250); ?></p>
            </div>
        <?php if(isset($report->images) && !empty($report->images)){ ?>
            <div class="col-3">
                <img src="<?php echo image($report->images[0], 'cropx180'); ?>" alt="<?php echo $report->titolo; ?> - immagine">
            </div>
        <?php } ?>

    </div>
    <?php } ?>
<?php dbga($reports); ?>

</div>
