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
-- Name: movie_cast; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE movie_cast (
    movie_id bigint,
    actor_name character varying(300),
    "character" character varying(300),
    uniq boolean
);


ALTER TABLE public.movie_cast OWNER TO postgres;

--
-- Name: movie_cast; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE movie_cast FROM PUBLIC;
REVOKE ALL ON TABLE movie_cast FROM postgres;
GRANT ALL ON TABLE movie_cast TO postgres;
GRANT ALL ON TABLE movie_cast TO teja;


--
-- PostgreSQL database dump complete
--

