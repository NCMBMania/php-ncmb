<?php

namespace Ncmb;

/**
 * Installation class
 */
class Installation extends Object
{
    /**
     * Constructor
     * @param string $className class name of objects
     * @param string $objectId object id
     */
    public function __construct($objectId = null)
    {
        parent::__construct(null, $objectId);
    }

    /**
     * Get path string of this object class
     * @return string path string
     */
    public function getApiPath()
    {
        return 'installations';
    }

	/**
	 * Installation Update
	 *
	 * @return $this
	 */
	public function update() {
		$path    = $this->getApiPath() . '/' . self::getObjectId();
		$options = [
			// FIXME: support operations
			'json' => $this->getSaveData(),
		];

		$data = ApiClient::put( $path, $options );
		$this->mergeAfterFetch( $data, false );

		return $this;
	}

}
