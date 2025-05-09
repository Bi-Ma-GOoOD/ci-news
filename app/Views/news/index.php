<!-- ตรวจสอบว่าค่าของ news_list != null -->
<?php if ($news_list != []): ?>

    <?php foreach ($news_list as $news_item): ?>

        <h3><?= esc($news_item['title']) ?></h3>

        <div class="main">
            <?= esc($news_item['body']) ?>
        </div>
        <!-- เอาค่า slug ของข่าว (เช่น "hello-world" หรือ "ข่าว-ใหม่-ล่าสุด") มาใส่ต่อท้าย URL -->
        <!-- example: $news_item['slug'] = "hello-world" -->
        <!-- <p><a href="/news/hello-world">View article</a></p> -->
        <p><a href="/news/<?= esc($news_item['slug'], 'url') ?>">View article</a></p>

    <?php endforeach ?>

<?php else: ?>

    <h3>No News</h3>

    <p>Unable to find any news for you.</p>

<?php endif ?>