CREATE OR REPLACE FUNCTION mcd_in_array(in_array1 BLOB,in_array2 BLOB) RETURNS boolean DETERMINISTIC
BEGIN
	DECLARE i INT UNSIGNED DEFAULT 0;
    DECLARE v_count INT UNSIGNED DEFAULT JSON_LENGTH(in_array2);
    DECLARE ret bool DEFAULT 0;
    WHILE i < v_count DO
        SET ret := JSON_CONTAINS(in_array1, JSON_EXTRACT(in_array2, CONCAT('$[', i, ']')));
        IF ret != 1 THEN
        return 0;
        END IF;
        SET i := i + 1;
    END WHILE;
    return 1;
END;