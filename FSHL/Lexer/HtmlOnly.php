<?php

/**
 * FSHL 2.0 RC                            | Universal Syntax HighLighter |
 * -----------------------------------------------------------------------
 *
 * LICENSE
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 */

namespace FSHL\Lexer;

use FSHL;

/**
 * HTML lexer without other languages.
 *
 * @copyright Copyright (c) 2002-2005 Juraj 'hvge' Durech
 * @copyright Copyright (c) 2011 Jaroslav Hanslík
 * @license https://github.com/kukulich/fshl/blob/master/LICENSE
 */
class HtmlOnly implements FSHL\Lexer
{
	/**
	 * Returns language name.
	 *
	 * @return string
	 */
	public function getLanguage()
	{
		return 'HtmlOnly';
	}

	/**
	 * Returns lexer version.
	 *
	 * @return string
	 */
	public function getVersion()
	{
		return '2.0';
	}

	/**
	 * Returns initial state.
	 *
	 * @return string
	 */
	public function getInitialState()
	{
		return 'OUT';
	}

	/**
	 * Returns states.
	 *
	 * @return array
	 */
	public function getStates()
	{
		return array(
			'OUT' => array(
				array(
					'<!--' => array('COMMENT', 0),
					'<?' => array('OUT', 1),
					'<' => array('TAG', 0),
					'&' => array('ENTITY', 0),
					'_LINE' => array('OUT', 0),
					'_TAB' => array('OUT', 0)
				),
				FSHL\Generator::STATE_FLAG_NONE,
				null,
				null
			),
			'ENTITY' => array(
				array(
					';' => array('OUT', 1),
					'&' => array('OUT', 1),
					'SPACE' => array('OUT', 1)
				),
				FSHL\Generator::STATE_FLAG_NONE,
				'html-entity',
				null
			),
			'TAG' => array(
				array(
					'>' => array('OUT', 1),
					'style' => array('STYLE', 1),
					'STYLE' => array('STYLE', 1),
					'script' => array('SCRIPT', 1),
					'SCRIPT' => array('SCRIPT', 1),
					'SPACE' => array('TAGIN', 0)
				),
				FSHL\Generator::STATE_FLAG_NONE,
				'html-tag',
				null
			),
			'TAGIN' => array(
				array(
					'"' => array('QUOTE1', 0),
					'\'' => array('QUOTE2', 0),
					'/>' => array('TAG', -1),
					'>' => array('TAG', -1),
					'_LINE' => array('TAGIN', 0),
					'_TAB' => array('TAGIN', 0)
				),
				FSHL\Generator::STATE_FLAG_NONE,
				'html-tagin',
				null
			),
			'STYLE' => array(
				array(
					'"' => array('QUOTE1', 0),
					'\'' => array('QUOTE2', 0),
					'>' => array('STYLE_END', -1),
					'_LINE' => array('STYLE', 0),
					'_TAB' => array('STYLE', 0)
				),
				FSHL\Generator::STATE_FLAG_NONE,
				'html-tagin',
				null
			),
			'STYLE_END' => array(
				array(
					'>' => array('CSS', 1)
				),
				FSHL\Generator::STATE_FLAG_NONE,
				'html-tag',
				null
			),
			'CSS' => array(
				array(
					'_LINE' => array('CSS', 0),
					'_TAB' => array('CSS', 0),
					'</style' => array('TAG', 0),
					'</STYLE' => array('TAG', 0),
				),
				FSHL\Generator::STATE_FLAG_NONE,
				null,
				null
			),
			'SCRIPT' => array(
				array(
					'"' => array('QUOTE1', 0),
					'\'' => array('QUOTE2', 0),
					'>' => array('SCRIPT_END', -1),
					'_LINE' => array('SCRIPT', 0),
					'_TAB' => array('SCRIPT', 0)
				),
				FSHL\Generator::STATE_FLAG_NONE,
				'html-tagin',
				null
			),
			'SCRIPT_END' => array(
				array(
					'>' => array('JAVASCRIPT', 1)
				),
				FSHL\Generator::STATE_FLAG_NONE,
				'html-tag',
				null
			),
			'JAVASCRIPT' => array(
				array(
					'_LINE' => array('JAVASCRIPT', 0),
					'_TAB' => array('JAVASCRIPT', 0),
					'</script' => array('TAG', 0),
					'</SCRIPT' => array('TAG', 0)
				),
				FSHL\Generator::STATE_FLAG_NONE,
				null,
				null
			),
			'QUOTE1' => array(
				array(
					'"' => array(FSHL\Generator::STATE_RETURN, 0)
				),
				FSHL\Generator::STATE_FLAG_RECURSION,
				'html-quote',
				null
			),
			'QUOTE2' => array(
				array(
					'\'' => array(FSHL\Generator::STATE_RETURN, 0)
				),
				FSHL\Generator::STATE_FLAG_RECURSION,
				'html-quote',
				null
			),
			'COMMENT' => array(
				array(
					'-->' => array('OUT', 1),
					'_LINE' => array('COMMENT', 0),
					'_TAB' => array('COMMENT', 0)
				),
				FSHL\Generator::STATE_FLAG_NONE,
				'html-comment',
				null
			)
		);
	}

	/**
	 * Returns special delimiters.
	 *
	 * @return array
	 */
	public function getDelimiters()
	{
		return array();
	}

	/**
	 * Returns keywords.
	 *
	 * @return array
	 */
	public function getKeywords()
	{
		return array();
	}
}
