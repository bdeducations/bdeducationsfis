ALTER TABLE `ut_hr_employees` ADD `employee_id` VARCHAR(50) NOT NULL AFTER `employee_row_id`;
ALTER TABLE `ut_hr_employees` ADD `show_attendance_report` TINYINT(1) NOT NULL DEFAULT '1' AFTER `employee_row_id`;

UPDATE `ut_hr_employees` SET `show_attendance_report` = '0' WHERE `ut_hr_employees`.`employee_row_id` = 97;
UPDATE `ut_hr_employees` SET `show_attendance_report` = '0' WHERE `ut_hr_employees`.`employee_row_id` = 129;
UPDATE `ut_hr_employees` SET `show_attendance_report` = '0' WHERE `ut_hr_employees`.`employee_row_id` = 130;
UPDATE `ut_hr_employees` SET `show_attendance_report` = '0' WHERE `ut_hr_employees`.`employee_row_id` = 131;
UPDATE `ut_hr_employees` SET `show_attendance_report` = '0' WHERE `ut_hr_employees`.`employee_row_id` = 132;

--
-- 
--
ALTER TABLE `ut_hr_employees` ADD `offday` VARCHAR(255) NOT NULL DEFAULT 'Friday,Saturday' AFTER `employee_name`;