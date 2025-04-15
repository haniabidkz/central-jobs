DROP TABLE IF EXISTS `best_advertisements`;
CREATE TABLE `best_advertisements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `initial_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `payment_cms`;
CREATE TABLE `payment_cms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `payment_cms` (`id`, `name`, `value`, `status`, `created_at`, `updated_at`, `deleted_at`, `user_id`) VALUES
(1,	'Free',	'0',	1,	'2021-04-15 15:13:10',	'2021-05-15 03:43:09',	'2021-04-15 15:13:10',	1),
(2,	'1 MONTH',	'14,90',	1,	'2021-04-15 15:13:10',	'2021-05-15 03:43:01',	'2021-04-15 15:13:10',	1),
(3,	'3 MONTHS',	'34,90',	1,	'2021-04-15 15:13:10',	'2021-05-15 03:42:52',	'2021-04-15 15:13:10',	1),
(4,	'6 MONTHS',	'54,90',	1,	'2021-04-15 15:13:10',	'2021-05-15 03:42:39',	'2021-04-15 15:13:10',	1);

DROP TABLE IF EXISTS `user_payment`;
CREATE TABLE `user_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-> Pending Payment, 1-> Paid',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


change enm in uploads table. add user_other_doc in enum.

add is_payment_done in user table.

add highlight_sentence to profile table.

add job_id DEFAULT 0, in uploads table.

add customer_id DEFAULT NULL, in users table.
add subscription_id DEFAULT NULL, in users table.
add subscription_plan_id DEFAULT NULL, in users table.
add card_id DEFAULT NULL, in users table.

CREATE TABLE `user_transaction_details` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) NOT NULL,
	`subscription_plan_id` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`card_id` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`customer_id` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`subscription_id` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`currency` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`amount` DOUBLE(8,2) NOT NULL,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `user_transaction_details_user_id_foreign` (`user_id`) USING BTREE,
	CONSTRAINT `user_transaction_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `silvia`.`users` (`id`) ON UPDATE RESTRICT ON DELETE RESTRICT
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=4
;

add `highlighted_cv`(boolean) column to users table (to recognize candidates with highlight cv)
add `highlighted`(boolean) column in posts table default(0)
add 'German' to `language_type` in page_content_text table

-- INSERT INTO `page_content_text` (`id`, `type`, `language_type`, `page_contents_id`, `text`, `created_at`, `updated_at`, `deleted_at`, `status`) 
-- VALUES 
-- (NULL, '1', 'German', '1', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '2', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '3', '', current_timestamp(), current_timestamp(), NULL, '1'), 
-- (NULL, '1', 'German', '4', '', current_timestamp(), current_timestamp(), NULL, '1'), 
-- (NULL, '1', 'German', '5', '', current_timestamp(), current_timestamp(), NULL, '1'), 
-- (NULL, '1', 'German', '6', '', current_timestamp(), current_timestamp(), NULL, '1'), 
-- (NULL, '1', 'German', '7', '', current_timestamp(), current_timestamp(), NULL, '1'), 
-- (NULL, '1', 'German', '8', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '12', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '13', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '14', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '15', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '17', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '18', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '19', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '20', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '21', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '23', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '24', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '25', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '26', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '27', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '28', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '29', '', current_timestamp(), current_timestamp(), NULL, '1'),
-- (NULL, '1', 'German', '30', '', current_timestamp(), current_timestamp(), NULL, '1');

UPDATE `page_content_text` SET `language_type`='German' WHERE `language_type`='French';

CREATE TABLE `company_transaction_histories` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`payment_id` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`user_id` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`amount` DOUBLE(10,2) NOT NULL,
	`currency` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`payment_status` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`balance_transaction` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`captured` TINYINT(1) NOT NULL,
	`paid` TINYINT(1) NOT NULL,
	`disputed` TINYINT(1) NOT NULL,
	`payment_method` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`receipt_url` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`description` TEXT NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
;
