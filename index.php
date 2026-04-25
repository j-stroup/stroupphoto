<?php
/**
 * Jeffrey Stroup Photography - Controller Logic
 */

// 1. Setup & Security
$allowed_pages = ['home', 'film', 'digital', 'about', 'books'];
$page = (isset($_GET['page']) && in_array($_GET['page'], $allowed_pages)) ? $_GET['page'] : 'home';

// 2. Data Fetching (Only run for gallery pages)
$photos = [];
if ($page === 'film' || $page === 'digital') {
    $directory = "images/" . $page . "/";
    if (is_dir($directory)) {
        $photos = glob($directory . "*.{jpg,jpeg,png,webp}", GLOB_BRACE);
        // Sort newest to oldest
        usort($photos, function($a, $b) { return filemtime($b) - filemtime($a); });
    }
}

include('header.php'); 
?>

<main>
    <div class="content-wrapper">

        <?php if ($page === 'home'): ?>
            <section class="home-hero-fullscreen">
                <div class="hero-bg" style="background-image: url('http://localhost/stroupphoto/images/digital/img-1019.jpg');"></div>
                
                <div class="hero-content">
                    <h1>Jeffrey Stroup</h1>
                    <p class="description">
                        From the rusted skeletons of industrial giants to the shadows of the underground, I document the parts of our world that exist on the edge of safety and legality.
                    </p>
                    <a href="index.php?page=digital" class="cta-button">Explore the Galleries</a>
                </div>
            </section>

        <?php elseif ($page === 'about'): ?>
            <section class="about-section">
                <h2>About Me</h2>
                <div class="about-grid">
                    <img src="images/about.jpg" alt="Jeffrey Stroup" class="about-image">
                    <div class="about-text">
                        <p>I had always wanted to be a photographer, and as luck would have it, I found a camera on the side of the road as a teenager. From that point on I always carried a camera with me.</p>
                        <p>Despite making a living shooting weddings and family photos, my real passion was always photographing lesser-known areas. Tunnels beneath the streets, ghost towns in the middle of the desert, massive old rust-belt factories—anywhere you might consider 'forgotten' or 'off-limits.'</p>
                        <p>After nearly two decades of exploring and photographing the world around me, my camera now spends more time on a shelf than it does in my hand. I'd rather focus my energy on other pursuits such as oil painting or writing computer programs.</p>
                    </div>
                </div>
            </section>

        <?php elseif ($page === 'books'): ?>
            <section class="books-container">
                <h2 class="section-title">Published Works</h2>
                <article class="book-entry">
                    <div class="book-cover">
                        <img src="http://localhost/stroupphoto/images/cleveland.jpg" alt="Abandoned Cleveland">
                    </div>
                    <div class="book-info">
                        <h3>Abandoned Cleveland</h3>
                        <p class="book-description">
                            A brief, atmospheric description of the project, the themes explored, and the technical process behind the photos.
                        </p>
                        <a href="https://link-to-purchase.com" class="buy-button" target="_blank">View Book</a>
                    </div>
                </article>
                <article class="book-entry">
                    <div class="book-cover">
                        <img src="http://localhost/stroupphoto/images/northernohio.jpg" alt="Abandoned Northern Ohio">
                    </div>
                    <div class="book-info">
                        <h3>Abandoned Northern Ohio</h3>
                        <p class="book-description">
                            A brief, atmospheric description of the project, the themes explored, and the technical process behind the photos.
                        </p>
                        <a href="https://link-to-purchase.com" class="buy-button" target="_blank">View Book</a>
                    </div>
                </article>
            </section>

        <?php else: ?>
            <section class="gallery-header">
                <h2><?php echo ucfirst($page); ?> Gallery</h2>
            </section>

            <div class="grid">
                <?php if (empty($photos)): ?>
                    <p class="empty-msg">No images found in the <?php echo $page; ?> directory.</p>
                <?php else: ?>
                    <?php foreach ($photos as $photo): $hash = md5($photo); ?>
                        <div class="gallery-item">
                            <a href="#<?php echo $hash; ?>">
                                <img src="<?php echo $photo; ?>" alt="Photography" loading="lazy">
                            </a>
                        </div>

                        <div id="<?php echo $hash; ?>" class="lightbox">
                            <a href="#!" class="lightbox-close" aria-label="Close"></a>
                            <div class="lightbox-content">
                                <img src="<?php echo $photo; ?>" alt="Full size">
                                <a href="#!" class="close-button">&times;</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php include('footer.php'); ?>