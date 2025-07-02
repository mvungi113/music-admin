

CREATE TABLE public.songs_v2 (
  id bigint NOT NULL DEFAULT nextval('songs_v2_id_seq'::regclass),
  user_id text NOT NULL,
  title text NOT NULL,
  genre text,
  language text,
  song_url text NOT NULL,
  lyrics_url text NOT NULL,
  status text NOT NULL DEFAULT 'pending'::text,
  quality double precision,
  offensive_count integer DEFAULT 0,
  created_at timestamp with time zone NOT NULL DEFAULT now(),
  offensive_words ARRAY,
  CONSTRAINT songs_v2_pkey PRIMARY KEY (id),
  CONSTRAINT fk_songs_user_id FOREIGN KEY (user_id) REFERENCES public.users(user_id)
);
CREATE TABLE public.users (
  id bigint GENERATED ALWAYS AS IDENTITY NOT NULL,
  user_id text UNIQUE,
  first_name text,
  last_name text,
  artist_name text,
  email text UNIQUE,
  phone text,
  created_at timestamp with time zone NOT NULL DEFAULT now(),
  CONSTRAINT users_pkey PRIMARY KEY (id)
);
