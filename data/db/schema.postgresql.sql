create table roles (
  id serial primary key,
  name text
);

create table users (
  id serial primary key,
  name text,
  email text unique,
  uuid text unique,
  username text unique,
  password text,
  enabled boolean not null default true,
  role_id integer references roles (id) on delete cascade on update cascade
);

create table sessions (
  id serial primary key,
  token text not null,
  valid boolean not null default true,
  expiration_date timestamp not null,
  ip_address text,
  user_id integer references users (id) on delete cascade on update cascade
);

create table bookmark_categories (
  id serial primary key,
  name text,
  user_id integer not null references users (id) on delete cascade on update cascade,
  parent_id integer references bookmark_categories (id) on delete cascade on update cascade
);

create table bookmarks (
  id serial primary key,
  name text not null,
  url text,
  favicon text,
  category_id integer references bookmark_categories (id) on delete cascade on update cascade
);

create type param_type as enum
(
  'integer', 'string', 'boolean'
);

create table config_params (
  id serial primary key,
  name text not null,
  type param_type not null
);

create table users_have_config_params (
  user_id serial primary key references users (id) on delete cascade on update cascade,
  config_param_id integer not null references config_params (id) on delete cascade on update cascade,
  value text
);

create table feed_folders (
  id serial primary key,
  name text not null,
  user_id integer not null references users (id) on delete cascade on update cascade,
  parent_id integer references feed_folders (id) on delete cascade on update cascade
);

create table subscriptions (
  id serial primary key,
  name text,
  url text,
  favicon text,
  user_id integer not null references users (id) on delete cascade on update cascade,
  folder_id integer references feed_folders (id) on delete cascade on update cascade
);

create table feeds (
  id serial primary key,
  title text,
  body text,
  url text,
  creation_date timestamp,
  modification_date timestamp,
  author text,
  read boolean not null default false,
  starred boolean not null default false,
  subscription_id integer references subscriptions (id) on delete cascade on update cascade
);

create table tags (
  id serial primary key,
  name text not null
);

create table feeds_have_tags (
  feed_id integer not null references feeds (id) on delete cascade on update cascade,
  tag_id integer not null references tags (id) on delete cascade on update cascade
);

create table shared_feeds (
  id serial primary key,
  public_url text,
  feed_id integer references feeds (id) on delete cascade on update cascade,
  user_id integer references users (id) on delete cascade on update cascade
);

create table comments (
  id serial primary key,
  body text,
  url text,
  user_id integer not null references users (id) on delete cascade on update cascade,
  feed_id integer not null references feeds (id) on delete cascade on update cascade,
  parent_id integer references comments (id) on delete set null on update cascade
);
