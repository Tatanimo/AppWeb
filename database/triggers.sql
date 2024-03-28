 DELIMITER //
 CREATE TRIGGER after_insert_users_image
 BEFORE INSERT ON users
 FOR EACH ROW
 BEGIN
 	IF new.image IS NULL THEN
    	SET new.image = "user_default.jpg";
    END IF;
 END; //
 DELIMITER ;