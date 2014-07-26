PRAGMA synchronous = OFF;
PRAGMA journal_mode = MEMORY;
BEGIN TRANSACTION;
CREATE TABLE "bookmark_categories" (
  "id" int(11) NOT NULL ,
  "name" varchar(256) DEFAULT NULL,
  "user_id" int(11) NOT NULL,
  "parent_id" int(11) DEFAULT NULL,
  PRIMARY KEY ("id"),
  CONSTRAINT "fk_bookmark_categories_1" FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT "fk_bookmark_categories_2" FOREIGN KEY ("parent_id") REFERENCES "bookmark_categories" ("id") ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE "bookmarks" (
  "id" int(11) NOT NULL ,
  "name" varchar(256) NOT NULL,
  "url" varchar(1024) DEFAULT NULL,
  "favicon" varchar(1024) DEFAULT NULL,
  "category_id" int(11) DEFAULT NULL,
  PRIMARY KEY ("id"),
  CONSTRAINT "fk_bookmarks_1" FOREIGN KEY ("category_id") REFERENCES "bookmark_categories" ("id") ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE "config_params" (
  "id" int(11) NOT NULL ,
  "name" varchar(256) NOT NULL,
  "type" text  NOT NULL,
  PRIMARY KEY ("id")
);
CREATE TABLE "feed_folders" (
  "id" int(11) NOT NULL ,
  "name" varchar(256) NOT NULL,
  "user_id" int(11) NOT NULL,
  "parent_id" int(11) DEFAULT NULL,
  PRIMARY KEY ("id"),
  CONSTRAINT "fk_feed_folders_1" FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT "fk_feed_folders_2" FOREIGN KEY ("parent_id") REFERENCES "feed_folders" ("id") ON DELETE SET NULL ON UPDATE CASCADE
);
CREATE TABLE "feeds_entries" (
  "id" int(11) NOT NULL ,
  "title" varchar(1024) DEFAULT NULL,
  "body" text,
  "url" varchar(1024) DEFAULT NULL,
  "creation_date" datetime DEFAULT NULL,
  "modification_date" datetime DEFAULT NULL,
  "author" varchar(512) DEFAULT NULL,
  "read" tinyint(1) NOT NULL DEFAULT '0',
  "starred" tinyint(1) NOT NULL DEFAULT '0',
  "subscription_id" int(11) DEFAULT NULL,
  PRIMARY KEY ("id"),
  CONSTRAINT "fk_feeds_1" FOREIGN KEY ("subscription_id") REFERENCES "subscriptions" ("id") ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE "feed_entries_have_tags" (
  "feed_id" int(11) NOT NULL,
  "tag_id" int(11) NOT NULL,
  PRIMARY KEY ("feed_id","tag_id"),
  CONSTRAINT "fk_feeds_have_tags_1" FOREIGN KEY ("feed_id") REFERENCES "feeds_entries" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT "fk_feeds_have_tags_2" FOREIGN KEY ("tag_id") REFERENCES "tags" ("id") ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE "roles" (
  "id" int(11) NOT NULL ,
  "name" varchar(128) DEFAULT NULL,
  PRIMARY KEY ("id")
);
CREATE TABLE "sessions" (
  "id" int(11) NOT NULL ,
  "token" varchar(256) NOT NULL,
  "valid" tinyint(1) NOT NULL DEFAULT '1',
  "expiration_date" datetime NOT NULL,
  "ip_address" varchar(50) DEFAULT NULL,
  "user_id" int(11) DEFAULT NULL,
  PRIMARY KEY ("id"),
  CONSTRAINT "fk_sessions_1" FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE "shared_feeds" (
  "id" int(11) NOT NULL ,
  "public_url" varchar(1024) DEFAULT NULL,
  "feed_id" int(11) NOT NULL,
  "user_id" int(11) DEFAULT NULL,
  PRIMARY KEY ("id"),
  CONSTRAINT "fk_shared_feeds_1" FOREIGN KEY ("feed_id") REFERENCES "feeds_entries" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT "fk_shared_feeds_2" FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE SET NULL ON UPDATE CASCADE
);
CREATE TABLE "subscriptions" (
  "id" int(11) NOT NULL ,
  "name" varchar(256) DEFAULT NULL,
  "url" varchar(1024) DEFAULT NULL,
  "favicon" varchar(1024) DEFAULT NULL,
  "user_id" int(11) NOT NULL,
  "folder_id" int(11) DEFAULT NULL,
  PRIMARY KEY ("id")
  CONSTRAINT "fk_subscriptions_1" FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT "fk_subscriptions_2" FOREIGN KEY ("folder_id") REFERENCES "feed_folders" ("id") ON DELETE SET NULL ON UPDATE CASCADE
);
CREATE TABLE "tags" (
  "id" int(11) NOT NULL ,
  "name" varchar(256) NOT NULL,
  PRIMARY KEY ("id")
);
CREATE TABLE "users" (
  "id" int(11) NOT NULL ,
  "name" varchar(256) DEFAULT NULL,
  "email" varchar(128) DEFAULT NULL,
  "uuid" varchar(40) DEFAULT NULL,
  "username" varchar(128) DEFAULT NULL,
  "password" varchar(128) DEFAULT NULL,
  "enabled" tinyint(1) NOT NULL DEFAULT '1',
  "role_id" int(11) DEFAULT NULL,
  PRIMARY KEY ("id"),
  CONSTRAINT "fk_users_1" FOREIGN KEY ("role_id") REFERENCES "roles" ("id")
);
CREATE TABLE "comments" (
  "id" int(11) NOT NULL,
  "body" text,
  "user_id" int(11) NOT NULL,
  "url" varchar(1024) DEFAULT NULL,
  "feed_id" int(11) NOT NULL,
  "parent_id" int(11) DEFAULT NULL,
  PRIMARY KEY ("id"),
  CONSTRAINT "fk_comments_1" FOREIGN KEY ("feed_id") REFERENCES "feeds_entries" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT "fk_comments_2" FOREIGN KEY ("parent_id") REFERENCES "comments" ("id") ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT "fk_comments_3" FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE "users_have_config_params" (
  "user_id" int(11) NOT NULL,
  "config_param_id" int(11) NOT NULL,
  "value" varchar(256) DEFAULT NULL,
  PRIMARY KEY ("user_id","config_param_id"),
  CONSTRAINT "fk_users_have_config_params_1" FOREIGN KEY ("config_param_id") REFERENCES "config_params" ("id") ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT "fk_users_have_config_params_2" FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE INDEX "users_have_config_params_fk_users_have_config_params_1_idx" ON "users_have_config_params" ("config_param_id");
CREATE INDEX "users_have_config_params_fk_users_have_config_params_2_idx" ON "users_have_config_params" ("user_id");
CREATE INDEX "bookmarks_fk_bookmarks_1_idx" ON "bookmarks" ("category_id");
CREATE INDEX "sessions_fk_sessions_1_idx" ON "sessions" ("user_id");
CREATE INDEX "shared_feeds_fk_shared_feeds_1_idx" ON "shared_feeds" ("feed_id");
CREATE INDEX "shared_feeds_fk_shared_feeds_2_idx" ON "shared_feeds" ("user_id");
CREATE INDEX "feeds_fk_feeds_1_idx" ON "feeds" ("subscription_id");
CREATE INDEX "bookmark_categories_fk_bookmark_categories_1_idx" ON "bookmark_categories" ("user_id");
CREATE INDEX "bookmark_categories_fk_bookmark_categories_2_idx" ON "bookmark_categories" ("parent_id");
CREATE INDEX "feeds_have_tags_fk_feeds_have_tags_2_idx" ON "feeds_have_tags" ("tag_id");
CREATE INDEX "comments_fk_comments_1_idx" ON "comments" ("feed_id");
CREATE INDEX "comments_fk_comments_2_idx" ON "comments" ("parent_id");
CREATE INDEX "comments_fk_comments_3_idx" ON "comments" ("user_id");
CREATE INDEX "users_username_UNIQUE" ON "users" ("username");
CREATE INDEX "users_uuid_UNIQUE" ON "users" ("uuid");
CREATE INDEX "users_email_UNIQUE" ON "users" ("email");
CREATE INDEX "users_fk_users_1_idx" ON "users" ("role_id");
CREATE INDEX "subscriptions_fk_subscriptions_1_idx" ON "subscriptions" ("user_id");
CREATE INDEX "subscriptions_fk_subscriptions_2_idx" ON "subscriptions" ("folder_id");
CREATE INDEX "feed_folders_fk_feed_folders_1_idx" ON "feed_folders" ("user_id");
CREATE INDEX "feed_folders_fk_feed_folders_2_idx" ON "feed_folders" ("parent_id");
END TRANSACTION;
