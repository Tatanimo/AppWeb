 DELIMITER //
 CREATE TRIGGER before_insert_articles_image
 BEFORE INSERT ON articles
 FOR EACH ROW
 BEGIN
 	IF new.image IS NULL THEN
    	SET new.image = "article_default.jpg";
    END IF;
 END; //
 DELIMITER ;

 DELIMITER //
 CREATE TRIGGER before_insert_category_animals_image
 BEFORE INSERT ON category_animals
 FOR EACH ROW
 BEGIN
	DECLARE fam_ani_img VARCHAR(50);
	SELECT image INTO fam_ani_img FROM family_animals WHERE id = new.fk_family_id;
 	IF new.image IS NULL THEN
		IF fam_ani_img IS NULL THEN
			SET new.image = "category_animal_default.jpg";
		ELSE
    		SET new.image = fam_ani_img;
		END IF;
    END IF;
 END; //
 DELIMITER ;

DELIMITER //
 CREATE TRIGGER before_insert_family_animals_image
 BEFORE INSERT ON family_animals
 FOR EACH ROW
 BEGIN
 	IF new.image IS NULL THEN
    	SET new.image = "family_animal_default.jpg";
    END IF;
 END; //
DELIMITER ;

DELIMITER //
 CREATE TRIGGER before_insert_users
 BEFORE INSERT ON users
 FOR EACH ROW
 BEGIN
 	IF new.created_date IS NULL THEN
    	SET new.created_date = NOW();
    END IF;
 END; //
DELIMITER ;