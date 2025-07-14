--
-- PostgreSQL database dump
--

-- Dumped from database version 12.20 (Ubuntu 12.20-1.pgdg22.04+1)
-- Dumped by pg_dump version 17.0 (Ubuntu 17.0-1.pgdg22.04+1)

-- Started on 2025-07-14 15:07:37 WIB

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 6 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO postgres;

--
-- TOC entry 2963 (class 0 OID 0)
-- Dependencies: 6
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 202 (class 1259 OID 38044)
-- Name: produk; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.produk (
    id_produk character varying NOT NULL,
    nama character varying,
    harga character varying,
    deskripsi character varying,
    gambar character varying
);


ALTER TABLE public.produk OWNER TO postgres;

--
-- TOC entry 2957 (class 0 OID 38044)
-- Dependencies: 202
-- Data for Name: produk; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.produk (id_produk, nama, harga, deskripsi, gambar) FROM stdin;
P001	Baju	150000	Warna Putih	\N
P002	Celana	200000	Jeans	\N
\.


--
-- TOC entry 2964 (class 0 OID 0)
-- Dependencies: 6
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE USAGE ON SCHEMA public FROM PUBLIC;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2025-07-14 15:07:37 WIB

--
-- PostgreSQL database dump complete
--

