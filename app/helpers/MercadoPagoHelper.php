<?php
/**
 * Helper para integración con MercadoPago
 * Documentación: https://www.mercadopago.com.co/developers/es/docs
 */

class MercadoPagoHelper {
    private $accessToken;
    private $publicKey;
    
    public function __construct() {
        $this->accessToken = MERCADOPAGO_ACCESS_TOKEN;
        $this->publicKey = MERCADOPAGO_PUBLIC_KEY;
    }
    
    /**
     * Crear preferencia de pago
     */
    public function crearPreferencia($datosPedido) {
        $url = 'https://api.mercadopago.com/checkout/preferences';
        
        $items = [];
        foreach ($datosPedido['items'] as $item) {
            $items[] = [
                'title' => $item['nombre'],
                'quantity' => (int)$item['cantidad'],
                'unit_price' => (float)$item['precio'],
                'currency_id' => 'COP'
            ];
        }
        
        $preferencia = [
            'items' => $items,
            'payer' => [
                'name' => $datosPedido['nombre_cliente'],
                'email' => $datosPedido['email_cliente'],
                'phone' => [
                    'number' => $datosPedido['telefono_cliente']
                ],
                'address' => [
                    'street_name' => $datosPedido['direccion'],
                    'zip_code' => $datosPedido['codigo_postal'] ?? ''
                ]
            ],
            'back_urls' => [
                'success' => URL_BASE . 'pago/exito',
                'failure' => URL_BASE . 'pago/fallo',
                'pending' => URL_BASE . 'pago/pendiente'
            ],
            'auto_return' => 'approved',
            'external_reference' => $datosPedido['pedido_id'],
            'statement_descriptor' => 'TENNIS Y FRAGANCIAS',
            'notification_url' => URL_BASE . 'webhooks/mercadopago'
        ];
        
        $response = $this->realizarPeticion($url, 'POST', $preferencia);
        
        return $response;
    }
    
    /**
     * Obtener información de un pago
     */
    public function obtenerPago($paymentId) {
        $url = "https://api.mercadopago.com/v1/payments/{$paymentId}";
        return $this->realizarPeticion($url, 'GET');
    }
    
    /**
     * Procesar webhook de notificación
     */
    public function procesarWebhook($data) {
        if (!isset($data['type']) || $data['type'] !== 'payment') {
            return false;
        }
        
        $paymentId = $data['data']['id'];
        $pago = $this->obtenerPago($paymentId);
        
        return [
            'payment_id' => $paymentId,
            'status' => $pago['status'],
            'status_detail' => $pago['status_detail'],
            'external_reference' => $pago['external_reference'],
            'transaction_amount' => $pago['transaction_amount'],
            'date_approved' => $pago['date_approved'] ?? null
        ];
    }
    
    /**
     * Realizar petición HTTP a la API
     */
    private function realizarPeticion($url, $metodo = 'GET', $datos = null) {
        $headers = [
            'Authorization: Bearer ' . $this->accessToken,
            'Content-Type: application/json'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        if ($metodo === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            return json_decode($response, true);
        }
        
        return false;
    }
    
    /**
     * Obtener public key para el frontend
     */
    public function obtenerPublicKey() {
        return $this->publicKey;
    }
}
?>

