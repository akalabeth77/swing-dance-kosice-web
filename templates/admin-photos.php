<section class="section-heading page-header">
    <div>
        <span class="eyebrow">📷 Správa Galérií</span>
        <h1>Fotoalbum Management</h1>
        <p>Pridávajte fotky z rôznych zdrojov (Facebook, Instagram, Google Photos, priame URL) do vlastných albumov.</p>
    </div>
</section>

<section class="section">
    <div class="card-grid two-up">
        <!-- List of Albums -->
        <article class="card">
            <div class="section-heading">
                <h2>Existujúce albumy (<?= count($galleries) ?>)</h2>
            </div>
            <div class="stack-list album-list">
                <?php if (empty($galleries)): ?>
                    <p style="text-align: center; color: #999; padding: 20px;">Žiadne albumy. Vytvorte si nový album.</p>
                <?php else: ?>
                    <?php foreach ($galleries as $album): ?>
                        <div class="stacked-item album-item">
                            <div class="section-heading">
                                <strong><?= e($album['title'] ?? 'Bez názvu') ?></strong>
                                <span class="meta"><?= get_source_label($album['source'] ?? 'manual') ?></span>
                            </div>
                            <p><?= e($album['description'] ?? '') ?: '<em>Bez popisu</em>' ?></p>
                            <small>Fotky: <strong><?= count($album['photos'] ?? []) ?></strong> | Vytvorené: <?= date('d.m.Y H:i', strtotime($album['created_at'] ?? 'now')) ?></small>
                            <div style="margin-top: 10px;">
                                <a class="button small" href="<?= url('/admin/photos/edit?id=' . urlencode($album['id'] ?? '')) ?>">Upraviť</a>
                                <a class="button small secondary" href="<?= url('/admin/photos/delete?id=' . urlencode($album['id'] ?? '') . '&confirm=1') ?>" onclick="return confirm('Naozaj chcete zmazať tento album?')">Zmazať</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </article>

        <!-- Create New Album Form -->
        <article class="card">
            <div class="section-heading">
                <h2>Vytvoriť nový album</h2>
            </div>
            <form method="POST" action="<?= url('/admin/photos/create') ?>" class="form-stack">
                <div class="form-group">
                    <label for="title">Názov albumu *</label>
                    <input type="text" id="title" name="title" required placeholder="Napr. Winter Swing Ball 2026">
                </div>
                <div class="form-group">
                    <label for="description">Popis (nepovinné)</label>
                    <textarea id="description" name="description" rows="3" placeholder="Stručný popis obsahu albumu..."></textarea>
                </div>
                <div class="form-group">
                    <label for="source">Zdroj albumov</label>
                    <select id="source" name="source">
                        <option value="manual">✏️ Manuálne pridané</option>
                        <option value="facebook">📘 Facebook</option>
                        <option value="instagram">📱 Instagram</option>
                        <option value="google-photos">🖼️ Google Photos</option>
                        <option value="local-media">💾 Lokálne súbory</option>
                    </select>
                </div>
                <button type="submit" class="button primary">Vytvoriť album</button>
            </form>
        </article>
    </div>
</section>

<section class="section">
    <article class="card">
        <div class="section-heading">
            <h2>📘 Importovať Facebook Album</h2>
        </div>
        <form method="POST" action="<?= url('/admin/photos/import-facebook') ?>" class="form-stack">
            <div class="form-group">
                <label for="fb_album_url">Facebook Album URL *</label>
                <input type="url" id="fb_album_url" name="fb_album_url" required 
                    placeholder="https://www.facebook.com/media/set/?set=a.1392415856008569&type=3"
                    pattern="https?://.*facebook\.com/.*">
                <small style="color: #999;">Otvorte si album na Facebooku a skopírujte URL z adresného riadka.</small>
            </div>
            <div class="form-group">
                <label for="fb_album_title">Názov albumu (nepovinné)</label>
                <input type="text" id="fb_album_title" name="album_title" placeholder="Ak necháte prázdne, použije sa predvolený názov">
            </div>
            <div class="form-group">
                <label for="fb_album_description">Popis albumu (nepovinné)</label>
                <textarea id="fb_album_description" name="album_description" rows="2" placeholder="Popis albumu..."></textarea>
            </div>
            <button type="submit" class="button primary">Importovať Facebook Album</button>
        </form>
    </article>
</section>

<?php if (!empty($editingAlbum)): ?>
<section class="section">
    <article class="card">
        <div class="section-heading">
            <h2>Upraviť album: <?= e($editingAlbum['title'] ?? 'Bez názvu') ?></h2>
        </div>
        
        <div class="card-grid two-up">
            <!-- Album Details -->
            <div>
                <h3>Detaily albumu</h3>
                <form method="POST" action="<?= url('/admin/photos/update') ?>" class="form-stack">
                    <input type="hidden" name="id" value="<?= e($editingAlbum['id'] ?? '') ?>">
                    
                    <div class="form-group">
                        <label for="edit_title">Názov *</label>
                        <input type="text" id="edit_title" name="title" value="<?= e($editingAlbum['title'] ?? '') ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_description">Popis</label>
                        <textarea id="edit_description" name="description" rows="3"><?= e($editingAlbum['description'] ?? '') ?></textarea>
                    </div>
                    
                    <button type="submit" class="button primary">Uložiť zmeny</button>
                </form>
            </div>
            
            <!-- Add Photo -->
            <div>
                <h3>Pridať fotku</h3>
                <form method="POST" action="<?= url('/admin/photos/add-photo') ?>" class="form-stack">
                    <input type="hidden" name="album_id" value="<?= e($editingAlbum['id'] ?? '') ?>">
                    
                    <div class="form-group">
                        <label for="photo_url">URL fotky *</label>
                        <input type="url" id="photo_url" name="src" placeholder="https://example.com/photo.jpg" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="photo_alt">Alt text (popis fotky)</label>
                        <input type="text" id="photo_alt" name="alt" placeholder="Popis pre dostupnosť">
                    </div>
                    
                    <div class="form-group">
                        <label for="photo_source">Zdroj fotky</label>
                        <select id="photo_source" name="source">
                            <option value="manual">Manuálne</option>
                            <option value="facebook">Facebook</option>
                            <option value="instagram">Instagram</option>
                            <option value="google-photos">Google Photos</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="button primary">Pridať fotku</button>
                </form>
            </div>
        </div>
        
        <!-- Photos in Album -->
        <div style="margin-top: 30px;">
            <h3>Fotky v albume (<?= count($editingAlbum['photos'] ?? []) ?>)</h3>
            
            <?php if (empty($editingAlbum['photos'])): ?>
                <p style="color: #999;">Album je prázdny. Pridajte prvú fotku vyššie.</p>
            <?php else: ?>
                <div class="photo-grid">
                    <?php foreach ($editingAlbum['photos'] as $photo): ?>
                        <figure style="position: relative;">
                            <img src="<?= e($photo['src']) ?>" alt="<?= e($photo['alt']) ?>" style="width: 100%; height: 200px; object-fit: cover;">
                            <figcaption style="padding: 5px; font-size: 0.85em;">
                                <small><?= e($photo['alt']) ?></small>
                            </figcaption>
                            <form method="POST" action="<?= url('/admin/photos/remove-photo') ?>" style="position: absolute; top: 5px; right: 5px;">
                                <input type="hidden" name="album_id" value="<?= e($editingAlbum['id'] ?? '') ?>">
                                <input type="hidden" name="photo_id" value="<?= e($photo['id'] ?? '') ?>">
                                <button type="submit" class="button small" style="background: rgba(0,0,0,0.5); color: white; padding: 5px 10px;" onclick="return confirm('Naozaj?')">✕</button>
                            </form>
                        </figure>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </article>
</section>
<?php endif; ?>
