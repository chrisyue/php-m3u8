<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\M3u8\MediaSegment;

class MediaSegment implements MediaSegmentInterface
{
	protected $uri;
	protected $duration;
	protected $sequence;
	protected $name;
	protected $group;
	protected $isDiscontinuity;

	public function __construct($uri, $duration, $sequence, $name, $group, $isDiscontinuity = false)
	{
		$this->uri = $uri;
		$this->duration = $duration;
		$this->sequence = $sequence;
		$this->name = $name;
		$this->group = $group;
		$this->isDiscontinuity = $isDiscontinuity;
	}

	public function getUri()
	{
		return $this->uri;
	}

	public function getDuration()
	{
		return $this->duration;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getGroup()
	{
		return $this->group;
	}

	public function getSequence()
	{
		return $this->sequence;
	}

	public function isDiscontinuity()
	{
		return $this->isDiscontinuity;
	}

}
