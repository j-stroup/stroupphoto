<?php
/**
 * Jeffrey Stroup Photography - Controller Logic
 */

// 1. Setup & Security
$allowed_pages = ['home', 'film', 'digital', 'about', 'books'];

// Check if page exists in allowed list
if (isset($_GET['page']) && in_array($_GET['page'], $allowed_pages)) {
    $page = $_GET['page'];
} elseif (!isset($_GET['page']) || $_GET['page'] === '') {
    $page = 'home';
} else {
    // If a page was requested but isn't allowed, trigger the 404
    header("HTTP/1.0 404 Not Found");
    include('404.php');
    exit; // Stop execution so it doesn't load index content below
}
// 2. Data Fetching (Only run for gallery pages)
$photos = [];
if ($page === 'film' || $page === 'digital') {
    // Relative URL for the <img> tags
    $web_path = "images/" . $page . "/";
    
    // Absolute SYSTEM path for glob() and is_dir()
    $server_path = $_SERVER['DOCUMENT_ROOT'] . "/" . $web_path;

    // Clean up double slashes just in case
    $server_path = str_replace('//', '/', $server_path);

    if (is_dir($server_path)) {
        // Look in the physical server folder
        $files = glob($server_path . "*.{jpg,jpeg,png,webp}", GLOB_BRACE);
        
        if ($files) {
            foreach ($files as $file) {
                // Convert the physical path back to a web URL for the browser
                $photos[] = $web_path . basename($file);
            }
            // Sort newest to oldest
            usort($photos, function($a, $b) { return filemtime($_SERVER['DOCUMENT_ROOT'] . "/" . $a) - filemtime($_SERVER['DOCUMENT_ROOT'] . "/" . $b); });
        }
    }
}
include('header.php'); 
?>

    <main>
        <?php if ($page === 'home'): ?>
            <section class="home-hero-fullscreen">
                <div class="hero-bg"></div>
                
                <div class="hero-content">
                    <h1>Jeffrey Stroup</h1>
                    <p class="description">
                        Fractured light. An obfuscated reality.
                        A world bleeding into entropy.
                        We only exist when we're unseen.
                        Dust. Rust. Tunnels. Silence.
                        The byproduct of a journey that doesn’t end.
                        Visual evidence of the overlooked.
                        Forgotten. Ignored. Misunderstandings yield to imagination.
                    </p>
                    <a href="digital" class="cta-button">Explore the Galleries</a>
                </div>
            </section>

        <?php elseif ($page === 'about'): ?>
            <div class="content-wrapper">
                <section class="about-section">
                    <h2 class="section-title">The Artist</h2>
                    
                    <div class="about-story">
                        <div class="story-block">
                            <span class="story-label">01 / The Origin</span>
                            <div class="story-content-with-image">
                                <p>My path into photography began with a stroke of luck: finding a camera on the side of the road as a teenager. From that moment on, I was never without one. It became a permanent extension of how I moved through the world, a tool for recording what others overlooked.</p>
                                <div class="about-portrait">
                                    <img src="images/jeffrey-stroup.jpg" alt="Jeffrey Stroup">
                                </div>
                            </div>
                        </div>

                        <div class="story-block">
                            <span class="story-label">02 / The Pursuit</span>
                            <p>While I spent years working professionally in traditional photography, my real focus has always lived on the periphery. For two decades, I have navigated the places most people avoid—the humid silence of tunnels beneath the streets, the skeletal remains of rust-belt factories, and the dust of desert ghost towns. My work is built on the risk of the "off-limits" and the beauty found in the breach.</p>
                        </div>

                        <div class="story-block">
                            <span class="story-label">03 / The Evolution</span>
                            <p>Over time, my focus has shifted from the act of trespassing to the act of seeing. While I still venture where others won't, I have increasingly moved toward documenting the city through a more abstract lens. I am drawn to the textures, geometries, and forgotten details that exist in plain sight but remain invisible to the casual observer.</p>
                        </div>

                        <div class="story-block">
                            <span class="story-label">04 / The Record</span>
                            <p>Whether I am deep underground or capturing the grit of a modern skyline, my goal remains the same: to create a permanent record of the world’s forgotten corners. This portfolio is a collection of twenty years of exploration—a visual byproduct of a life spent looking for the reality hidden behind the static of everyday life.</p>
                        </div>
                    </div>
                </section>
            </div>

            <?php elseif ($page === 'books'): ?>
                <div class="content-wrapper">
                    <section class="books-container">
                        <h2 class="section-title">Published Works</h2>
                        
                        <article class="book-entry">
                            <div class="book-cover">
                                <img src="images/cleveland.jpg" alt="Abandoned Cleveland">
                            </div>
                            <div class="book-info">
                                <h3>Abandoned Cleveland</h3>
                                <p class="book-description">
                                    When most of the industry left and Cleveland's population plummeted, what was left was a multitude of abandoned structures. I've been exploring these buildings for more than two decades now, and this book is a visual archive of those adventures. Some of the buildings in this book have been renovated, repurposed, or brought back to life; and some have been reduced to rubble in a landfill. My goal in publishing this book is to share those final glimpses into Cleveland's past.
                                </p>
                                <a href="https://amzn.to/4uiFX1r" class="buy-button" target="_blank">View Book</a>
                            </div>
                        </article>

                        <article class="book-entry">
                            <div class="book-cover">
                                <img src="images/northernohio.jpg" alt="Abandoned Northern Ohio">
                            </div>
                            <div class="book-info">
                                <h3>Abandoned Northern Ohio</h3>
                                <p class="book-description">
                                    With Rustbelt cities like Cleveland and Youngstown sitting alongside miles upon miles of farms, woodlands, and urban sprawl; the variety of abandoned structures scattered throughout the northern half of the state is staggering. This book aims to tell the history of these places, as well as some of my own personal stories and feelings about these forgotten and neglected spaces.
                                </p>
                                <a href="https://amzn.to/4vUTw8O" class="buy-button" target="_blank">View Book</a>
                            </div>
                        </article>
                    </section>
                </div>

        <?php else: ?>
            <div class="content-wrapper">
            <section class="gallery-header">
                <h2><?php if ($page === 'film'): echo '35mm, 120, and various instant films'; ?></h2>
                <h2><?php elseif ($page === 'digital'): echo 'Digital Photos'; ?></h2><?php endif; ?>
            </section>

            <div class="grid">
                <?php if (empty($photos)): ?>
                    <p class="empty-msg">No images found in the <?php echo $page; ?> directory.</p>
                <?php else: ?>
                    <?php foreach ($photos as $photo): $hash = md5($photo); ?>
                        <div class="gallery-item">
                            <a href="#<?php echo $hash; ?>">
                                <div class="blur-load" style="background-image: url('<?php echo $photo; ?>');">
                                    <img src="<?php echo $photo; ?>" 
                                         alt="Photography" 
                                         loading="lazy">
                                </div>
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
                </div>
                    <div class="gallery-footer">
               <?php if ($page === 'film'): ?><a href="digital" class="gallery-nav-link">Digital Photos</a>
               <?php elseif ($page === 'digital'): ?><a href="film" class="gallery-nav-link">Film Photos</a><?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php include('footer.php'); ?>