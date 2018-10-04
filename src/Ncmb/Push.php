<?php
namespace Ncmb;

/**
 * Push  - Handles sending push notifications with NCMB.
 */
class Push extends NCMBObject
{
    const VALID_OPTION_KEY = [
        'deliveryTime',
        'immediateDeliveryFlag',
        'target',
        'searchCondition',
        'message',
        'userSettingValue',
        'deliveryExpirationDate',
        'deliveryExpirationTime',
        'action',
        'title',
        'dialog',
        'badgeIncrementFlag',
        'badgeSetting',
        'sound',
        'contentAvailable',
        'richUrl',
        'category',
        'acl',
    ];

    const PATH_PREFIX = 'push';

    const DUMMY_CLASS_NAME = '__push__';

    /**
     * @var Push status
     */
    const STAT_NOT_SEND = 0;
    const STAT_SENDING = 1;
    const STAT_SEND_OK = 2;
    const STAT_OVER_LIMIT = 3;
    const STAT_ERROR = 4;
    const STAT_FLAG_OFF = 5;
    const STAT_PARTIAL_ERROR = 6;

    public function __construct($objectId = null)
    {
        parent::__construct(null, $objectId);
    }

    /**
     * Send push notification
     * @param array $options
     * @return string objectId of the registration for push
     */
    public static function send($options)
    {
        $data = static::encodeOptions($options);

        $apiPath = self::PATH_PREFIX;
        $apiOptions = [
            'json' => $data,
        ];
        $response = ApiClient::post($apiPath, $apiOptions);

        return $response['objectId'];
    }

    /**
     * Update registered push notification
     * @param string $id push id
     * @param array $options
     */
    public static function update($id, $options)
    {
        $data = static::encodeOptions($options);
        $apiPath = self::PATH_PREFIX . '/' . $id;
        $apiOptions = [
            'json' => $data,
        ];
        ApiClient::put($apiPath, $apiOptions);
    }

    /**
     * Delete registered push notification
     * @param string $id push id
     */
    public static function delete($id)
    {
        $apiPath = self::PATH_PREFIX . '/' . $id;
        ApiClient::delete($apiPath);
    }

    protected static function encodeOptions($options)
    {
        $deliveryTime = $immediateDeliveryFlag = null;
        $data = [];

        foreach ($options as $key => $val) {
            if (!in_array($key, self::VALID_OPTION_KEY)) {
                throw new Exception('Invalid option with Push::send');
            }
            if ($key === 'deliveryTime') {
                $deliveryTime = $val;
            }
            if ($key === 'immediateDeliveryFlag') {
                $immediateDeliveryFlag = $val;
            }

            if (is_object($val) && $val instanceof Encodable) {
                $data[$key] = $val->encode();
            } else {
                $data[$key] = $val;
            }
        }
        if ($deliveryTime === null && $immediateDeliveryFlag === null) {
            throw new Exception('deliveryTime or immediateDeliveryFlag is required');
        }
        return $data;
    }

    /**
     * Get Query object
     * @return \Ncmb\Query
     */
    public static function getQuery()
    {
        $query = new Query(self::DUMMY_CLASS_NAME);
        $query->setApiPath(self::PATH_PREFIX);
        return $query;
    }
}
