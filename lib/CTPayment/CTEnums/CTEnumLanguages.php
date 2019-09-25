<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * The Computop Shopware Plugin is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Computop Shopware Plugin is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Computop Shopware Plugin. If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP version 5.6, 7.0 , 7.1
 *
 * @category   Payment
 * @package    FatchipCTPayment
 * @subpackage CTPayment_CTEnums
 * @author     FATCHIP GmbH <support@fatchip.de>
 * @copyright  2018 Computop
 * @license    <http://www.gnu.org/licenses/> GNU Lesser General Public License
 * @link       https://www.computop.com
 */


namespace Fatchip\CTPayment\CTEnums;

/**
 * Class CTEnumEasyCredit
 * @package Fatchip\CTPayment\CTEnums
 */
class CTEnumLanguages
{
    const DEFAULT_LANGUAGE = 'de';

    // ISO-639-1 codes of languages supported by CompuTop
    const supportedLanguages = [
        'de',
        'al',
        'cs',
        'da',
        'dk',
        'en',
        'fi',
        'fr',
        'el',
        'hu',
        'it',
        'jp',
        'hu',
        'it',
        'ja',
        'nl',
        'no',
        'pl',
        'pt',
        'ro',
        'ru',
        'es',
        'se',
        'sk',
        'sl',
        'tr',
        'zh',
    ];

    // ISO-631-1 => CompuTop
    const languageCodeMap = [
        'cs' => 'cz',
        'da' => 'dk',
        'el' => 'gr',
        'ja' => 'jp',
        'nb' => 'no',
        'nn' => 'no',
    ];

    /**
     * Determine the CompuTop language code to use for a given ISO-631-1 language
     *
     * @param string|null $isoLanguage
     * @return mixed|string
     */
    public static function getComputopLanguageCode($isoLanguage)
    {
        if ($isoLanguage === null || $isoLanguage === '') {
            return self::DEFAULT_LANGUAGE;
        }

        if (!in_array($isoLanguage, self::supportedLanguages)) {
            return self::DEFAULT_LANGUAGE;
        }

        if (array_key_exists($isoLanguage, self::languageCodeMap)) {
            return self::languageCodeMap[$isoLanguage];
        }

        return $isoLanguage;
    }
}
