-- =====================================================================
--  Oweili · art_styles table for the admin styles manager
--  Run once in phpMyAdmin (DB u405344949_contact).
--  Seeds the 12 art styles; the admin can edit/add/delete afterwards.
-- =====================================================================
CREATE TABLE IF NOT EXISTS `art_styles` (
  `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title_en`        VARCHAR(150) NOT NULL DEFAULT '',
  `title_ar`        VARCHAR(150) NOT NULL DEFAULT '',
  `description_en`  TEXT NULL,
  `description_ar`  TEXT NULL,
  `tag`             VARCHAR(50) NOT NULL DEFAULT 'Traditional',
  `image_url`       VARCHAR(500) NOT NULL DEFAULT '',
  `sort_order`      INT NOT NULL DEFAULT 0,
  `created_at`      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_styles_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `art_styles` (`title_en`,`title_ar`,`description_en`,`description_ar`,`tag`,`sort_order`) VALUES
('Watercolor','ألوان مائية','Luminous, translucent washes built up in layers.','طبقات شفافة ومضيئة من الألوان المائية.','Traditional',1),
('Oil Painting','رسم زيتي','Rich, blendable color with timeless depth.','ألوان غنية قابلة للمزج بعمق خالد.','Traditional',2),
('Acrylic','أكريليك','Fast-drying, versatile and boldly pigmented.','سريع الجفاف، متعدد الاستخدامات وبألوان جريئة.','Traditional',3),
('Charcoal','فحم','Expressive black-and-white tonal drawing.','رسم تعبيري بالأبيض والأسود.','Traditional',4),
('Ink & Pen','حبر وقلم','Crisp lines and confident cross-hatching.','خطوط واضحة وتظليل متقاطع واثق.','Traditional',5),
('Pastel','باستيل','Soft, powdery color with a velvet finish.','ألوان ناعمة بلمسة مخملية.','Traditional',6),
('Digital Painting','رسم رقمي','Painterly work created on screen with a stylus.','عمل تصويري يُنشأ رقمياً بالقلم.','Digital',7),
('3D Art','فن ثلاثي الأبعاد','Modeled and rendered three-dimensional scenes.','مشاهد مجسّمة ثلاثية الأبعاد.','Digital',8),
('Vector Art','فن المتجهات','Clean, scalable shapes and flat design.','أشكال نظيفة قابلة للتحجيم وتصميم مسطح.','Digital',9),
('Pixel Art','فن البكسل','Retro imagery built pixel by pixel.','صور بأسلوب ريترو تُبنى بكسلاً بكسل.','Digital',10),
('Collage','كولاج','Assembled fragments into a new whole.','قصاصات مجمّعة في عمل واحد جديد.','Mixed Media',11),
('Mixed Media','وسائط مختلطة','Combining materials and techniques freely.','مزج المواد والتقنيات بحرية.','Mixed Media',12);
