<?php
namespace Hypework\Shipping\Model\Inter;

interface RegionInterface
{
	const ENTITY_ID = 'entity_id';
	const NAME = 'name';
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';


	public function getEntityId();
	public function setEntityId($id);

	public function getName();
	public function setName($name);

	public function getCreatedAt();
	public function setCreatedAt($createdAt);

	public function getUpdatedAt();
	public function setUpdatedAt($updatedAt);
}