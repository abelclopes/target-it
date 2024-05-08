<?php

/**
 * @OA\OpenApi(
 *   @OA\Info(
 *     title="API de Usuários",
 *     version="1.0.0",
 *     description="Uma API simples para gerenciamento de usuários com autenticação JWT.",
 *     @OA\Contact(
 *       email="suporte@example.com",
 *       name="Suporte Técnico"
 *     )
 *   )
 * )
 *
 * @OA\Server(
 *   url="http://localhost:8000/api",
 *   description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT"
 * )
 */
