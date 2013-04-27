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
-- Name: user_data; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE user_data (
    movie_id integer NOT NULL,
    user_id integer NOT NULL,
    watched character varying(300)
);


ALTER TABLE public.user_data OWNER TO postgres;

--
-- Name: user_data; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE user_data FROM PUBLIC;
REVOKE ALL ON TABLE user_data FROM postgres;
GRANT ALL ON TABLE user_data TO postgres;
GRANT ALL ON TABLE user_data TO teja;
