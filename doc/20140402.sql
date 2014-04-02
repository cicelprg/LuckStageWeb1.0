SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `luckstageweb` DEFAULT CHARACTER SET utf8 ;
CREATE SCHEMA IF NOT EXISTS `luckstageweb` DEFAULT CHARACTER SET utf8 ;
USE `luckstageweb` ;

-- -----------------------------------------------------
-- Table `luckstageweb`.`user_classify`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`user_classify` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`user_classify` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `classify` CHAR(10) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
COMMENT = '用户分类表：用户3类用户 普通用户、高级用户 和管理用户';


-- -----------------------------------------------------
-- Table `luckstageweb`.`high_userinfo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`high_userinfo` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`high_userinfo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `true_name` VARCHAR(30) NOT NULL ,
  `user_address` VARCHAR(100) NOT NULL ,
  `user_pic` VARCHAR(50) NOT NULL ,
  `user_bankname` VARCHAR(45) NOT NULL ,
  `user_bankid` VARCHAR(30) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
COMMENT = '高级用户信息表，存储了高级用户的真实姓名，用户的地址,用户的图片，开户银行和账号';


-- -----------------------------------------------------
-- Table `luckstageweb`.`user_baseinfo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`user_baseinfo` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`user_baseinfo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_name` VARCHAR(30) NOT NULL COMMENT '用户昵称' ,
  `user_hash` INT NOT NULL COMMENT '用户名hash 用于建立用户文件夹时，避免出现中文乱码,当出现hash冲突是在hash值上加1' ,
  `user_pwd` CHAR(32) NOT NULL COMMENT '用户密码，MD5 加密' ,
  `user_sex` CHAR(3) NOT NULL COMMENT '性别' ,
  `user_eamil` VARCHAR(30) NOT NULL COMMENT '电子邮件' ,
  `integral` INT NOT NULL DEFAULT 0 COMMENT '积分' ,
  `projects` SMALLINT NOT NULL DEFAULT 0 COMMENT '项目数量' ,
  `user_intro` VARCHAR(500) NOT NULL COMMENT '用户简介' ,
  `user_status` INT NOT NULL COMMENT '高级用户状态，是否被审核' ,
  `is_public` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '信息是否公开' ,
  `classify_id` INT NOT NULL DEFAULT 1 COMMENT '用户分类外键' ,
  `high_userid` INT NOT NULL DEFAULT 1 COMMENT '高级用户外键默认1 表示普通用户' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_user_baseinfo_user_classify_idx` (`classify_id` ASC) ,
  INDEX `fk_user_baseinfo_high_userinfo1_idx` (`high_userid` ASC) ,
  CONSTRAINT `fk_user_baseinfo_user_classify`
    FOREIGN KEY (`classify_id` )
    REFERENCES `luckstageweb`.`user_classify` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_baseinfo_high_userinfo1`
    FOREIGN KEY (`high_userid` )
    REFERENCES `luckstageweb`.`high_userinfo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '用户基本信息表，存储了用户的昵称,密码，性别，电子邮件，积分，项目数量，用户简介';


-- -----------------------------------------------------
-- Table `luckstageweb`.`t_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`t_status` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`t_status` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `status_name` VARCHAR(15) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
COMMENT = '状态表，\n项目状态：1、正在开发 2、已近完成   \n需求状态:1、待委托 2、正在进行  \n申请状态:1、待审核 2、审核通过 ，审核不通过\n任务状态:1、正在进行 2、完成任务';


-- -----------------------------------------------------
-- Table `luckstageweb`.`project_attr`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`project_attr` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`project_attr` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `attr_name` CHAR(6) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
COMMENT = '项目属性表：1、公开 2、私有';


-- -----------------------------------------------------
-- Table `luckstageweb`.`project_info`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`project_info` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`project_info` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `project_name` VARCHAR(60) NOT NULL COMMENT '项目名称' ,
  `projecthash` INT NOT NULL COMMENT '项目名称映射的hash值 用于建立项目文件夹，避免中文建立是字符乱码,一搬一个用户不会出先hash冲突' ,
  `require_userid` INT NOT NULL COMMENT '需求提供者id' ,
  `head_id` INT NOT NULL COMMENT '组长id' ,
  `create_date` TIMESTAMP NOT NULL COMMENT '创建日期' ,
  `project_path` VARCHAR(100) NOT NULL COMMENT '项目绝对路径' ,
  `project_info` VARCHAR(500) NOT NULL DEFAULT ' ' ,
  `downums` INT NOT NULL DEFAULT 0 COMMENT '下载次数' ,
  `attr_id` INT NOT NULL COMMENT '项目属性' ,
  `complete_date` TIMESTAMP NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_project_info_project_attr1_idx` (`attr_id` ASC) ,
  CONSTRAINT `fk_project_info_project_attr1`
    FOREIGN KEY (`attr_id` )
    REFERENCES `luckstageweb`.`project_attr` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '项目信息表，保存项目名称，项目创建日期,项目创建者,需求提供者,项目保存的绝对路径,项目简介';


-- -----------------------------------------------------
-- Table `luckstageweb`.`project_document`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`project_document` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`project_document` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `doc_name` VARCHAR(45) NOT NULL ,
  `doc_path` VARCHAR(45) NOT NULL ,
  `create_user` VARCHAR(30) NOT NULL ,
  `project_id` INT NOT NULL ,
  `create_date` TIMESTAMP NOT NULL ,
  `des` VARCHAR(200) NOT NULL DEFAULT ' ' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_project_document_project_info1_idx` (`project_id` ASC) ,
  CONSTRAINT `fk_project_document_project_info1`
    FOREIGN KEY (`project_id` )
    REFERENCES `luckstageweb`.`project_info` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '项目文档管理表，存储了文档名，路径(绝对路径)，从属项目，创建时间,创建者，描述';


-- -----------------------------------------------------
-- Table `luckstageweb`.`requirements`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`requirements` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`requirements` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `require_name` VARCHAR(45) NOT NULL COMMENT '需求名称' ,
  `require_des` VARCHAR(500) NOT NULL COMMENT '需求描述' ,
  `require_file` VARCHAR(100) NOT NULL DEFAULT ' ' COMMENT '需求附件路径，绝对路径' ,
  `sub_date` TIMESTAMP NOT NULL COMMENT '提出的时间' ,
  `pay_money` FLOAT NOT NULL DEFAULT 0.0 COMMENT '预付的金钱' ,
  `status_id` INT NOT NULL COMMENT '表示当前需求的状态' ,
  `complete_time` TIMESTAMP NULL COMMENT '完成时间' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_requirements_t_status1_idx` (`status_id` ASC) ,
  CONSTRAINT `fk_requirements_t_status1`
    FOREIGN KEY (`status_id` )
    REFERENCES `luckstageweb`.`t_status` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '需求列表，字段 paymoney 为以后扩展用';


-- -----------------------------------------------------
-- Table `luckstageweb`.`disscus`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`disscus` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`disscus` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `dis_content` VARCHAR(200) NOT NULL ,
  `user_name` VARCHAR(30) NOT NULL ,
  `dis_time` TIMESTAMP NOT NULL ,
  `parent_id` INT NOT NULL ,
  `project_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_disscus_disscus1_idx` (`parent_id` ASC) ,
  INDEX `fk_disscus_project_info1_idx` (`project_id` ASC) ,
  CONSTRAINT `fk_disscus_disscus1`
    FOREIGN KEY (`parent_id` )
    REFERENCES `luckstageweb`.`disscus` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_disscus_project_info1`
    FOREIGN KEY (`project_id` )
    REFERENCES `luckstageweb`.`project_info` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '单个项目讨论表，讨论内容，时间，作者，时间';


-- -----------------------------------------------------
-- Table `luckstageweb`.`project_mission`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`project_mission` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`project_mission` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `mission_name` VARCHAR(200) NOT NULL COMMENT '任务名' ,
  `assign_userid` INT NOT NULL COMMENT '指派给那个人' ,
  `create_userid` INT NOT NULL COMMENT '任务发布者' ,
  `create_date` INT NOT NULL COMMENT '发布日期' ,
  `status_id` INT NOT NULL COMMENT '任务状态' ,
  `project_id` INT NOT NULL COMMENT '项目id' ,
  `mission_des` VARCHAR(500) NOT NULL DEFAULT '' COMMENT '任务描述' ,
  `complete_date` TIMESTAMP NULL COMMENT '完成日期' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_project_mission_project_info1_idx` (`project_id` ASC) ,
  INDEX `fk_project_mission_t_status1_idx` (`status_id` ASC) ,
  CONSTRAINT `fk_project_mission_project_info1`
    FOREIGN KEY (`project_id` )
    REFERENCES `luckstageweb`.`project_info` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_project_mission_t_status1`
    FOREIGN KEY (`status_id` )
    REFERENCES `luckstageweb`.`t_status` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '项目任务表,任务名称，指派给谁,创建者，创建时间，任务状态，任务描述';


-- -----------------------------------------------------
-- Table `luckstageweb`.`payment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`payment` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`payment` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `pay_userid` INT NOT NULL ,
  `recive_userid` INT NOT NULL ,
  `pay_date` DATE NOT NULL ,
  `pay_requireid` INT NOT NULL ,
  `extra` VARCHAR(200) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
COMMENT = '支付表预留接口';


-- -----------------------------------------------------
-- Table `luckstageweb`.`user_activity_recordy`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`user_activity_recordy` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`user_activity_recordy` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `activity_date` DATE NOT NULL ,
  `activity_des` TEXT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
COMMENT = '客户履历表，扩展用';


-- -----------------------------------------------------
-- Table `luckstageweb`.`user_project`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`user_project` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`user_project` (
  `user_id` INT NOT NULL ,
  `project_id` INT NOT NULL ,
  `status_id` INT NOT NULL COMMENT '表示用户与当前项目的关系,审核加入,成员,审核不通过' ,
  PRIMARY KEY (`user_id`, `project_id`) ,
  INDEX `fk_user_project_project_info1_idx` (`project_id` ASC) ,
  INDEX `fk_user_project_t_status1_idx` (`status_id` ASC) ,
  CONSTRAINT `fk_user_project_user_baseinfo1`
    FOREIGN KEY (`user_id` )
    REFERENCES `luckstageweb`.`user_baseinfo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_project_project_info1`
    FOREIGN KEY (`project_id` )
    REFERENCES `luckstageweb`.`project_info` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_project_t_status1`
    FOREIGN KEY (`status_id` )
    REFERENCES `luckstageweb`.`t_status` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '用户和项目的关系表，一个用户可以同时参与多个项目,一个项目中又包含多个项目，属于中间表';


-- -----------------------------------------------------
-- Table `luckstageweb`.`publish_project`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`publish_project` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`publish_project` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `link` VARCHAR(100) NOT NULL ,
  `project_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_publish_project_project_info1_idx` (`project_id` ASC) ,
  CONSTRAINT `fk_publish_project_project_info1`
    FOREIGN KEY (`project_id` )
    REFERENCES `luckstageweb`.`project_info` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `luckstageweb`.`complete_mission`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`complete_mission` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`complete_mission` (
  `complete__id` INT NOT NULL AUTO_INCREMENT ,
  `mission_id` INT NOT NULL ,
  `complete_des` VARCHAR(1000) NOT NULL DEFAULT ' ' ,
  PRIMARY KEY (`complete__id`) ,
  INDEX `fk_complete_mission_project_mission1_idx` (`mission_id` ASC) ,
  CONSTRAINT `fk_complete_mission_project_mission1`
    FOREIGN KEY (`mission_id` )
    REFERENCES `luckstageweb`.`project_mission` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '任务完成的相关资料说明';


-- -----------------------------------------------------
-- Table `luckstageweb`.`notaccess`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`notaccess` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`notaccess` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `classid` INT NOT NULL DEFAULT 1 COMMENT '用户或者是项目分类\\n1,表示用户，2表示项目' ,
  `upid` INT NOT NULL COMMENT '对应的用户id或者是项目id' ,
  `reasons` VARCHAR(500) NOT NULL DEFAULT '' COMMENT '原因' ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
COMMENT = '项目和高级用户没有审核没有通过的原因记录';

USE `luckstageweb` ;

-- -----------------------------------------------------
-- Table `luckstageweb`.`aplay_require`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `luckstageweb`.`aplay_require` ;

CREATE  TABLE IF NOT EXISTS `luckstageweb`.`aplay_require` (
  `user_id` INT NOT NULL ,
  `re_id` INT NOT NULL ,
  `status_id` INT NOT NULL ,
  INDEX `fk_aplay_require_user_baseinfo_idx` (`user_id` ASC) ,
  PRIMARY KEY (`user_id`, `re_id`) ,
  INDEX `fk_aplay_require_requirements1_idx` (`re_id` ASC) ,
  INDEX `fk_aplay_require_t_status1_idx` (`status_id` ASC) ,
  CONSTRAINT `fk_aplay_require_user_baseinfo`
    FOREIGN KEY (`user_id` )
    REFERENCES `luckstageweb`.`user_baseinfo` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_aplay_require_requirements1`
    FOREIGN KEY (`re_id` )
    REFERENCES `luckstageweb`.`requirements` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_aplay_require_t_status1`
    FOREIGN KEY (`status_id` )
    REFERENCES `luckstageweb`.`t_status` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '用户申请接手需求表,属于中间表';



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
