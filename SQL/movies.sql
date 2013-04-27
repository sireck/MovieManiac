--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: movies; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE movies (
    id bigint NOT NULL,
    title character varying(300),
    year integer,
    mpaa_rating character varying(50),
    runtime integer,
    theatre_release_date date,
    dvd_release_date date,
    critic_score integer,
    audience_score integer,
    synopsis text,
    studio character varying(300),
    thumbnail_poster text,
    profile_poster text,
    imdb_id character varying(50),
    num_user_ratings integer DEFAULT 100
);


ALTER TABLE public.movies OWNER TO postgres;

--
-- Name: movies_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY movies
    ADD CONSTRAINT movies_pkey PRIMARY KEY (id);


--
-- Name: movies; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE movies FROM PUBLIC;
REVOKE ALL ON TABLE movies FROM postgres;
GRANT ALL ON TABLE movies TO postgres;
GRANT ALL ON TABLE movies TO teja;
GRANT ALL ON TABLE movies TO teja2;


--
-- PostgreSQL database dump complete
--

