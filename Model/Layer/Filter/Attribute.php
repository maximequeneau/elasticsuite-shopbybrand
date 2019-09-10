<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category  Smile
 * @package   Smile\ElasticsuiteShopbybrand
 * @author    Maxime Queneau <maxime.queneau@smile.fr>
 * @copyright 2019 Smile
 * @license   Open Software License ("OSL") v. 3.0
 */
namespace Smile\ElasticsuiteShopbybrand\Model\Layer\Filter;

use Smile\ElasticsuiteCatalog\Model\Layer\Filter\Attribute as BaseAttribute;

/**
 * Shopbybrand filter Attribute class
 * Add shopbybrand function and extend elasticsuiteCatalog module
 *
 * @author    Maxime Queneau <maxime.queneau@smile.fr>
 * @copyright 2019 Smile
 */
class Attribute extends BaseAttribute
{
    /**
     * Apply attribute option filter to product collection
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return $this
     */
    public function apply(\Magento\Framework\App\RequestInterface $request)
    {
        $attributeValue = $request->getParam($this->_requestVar);
        if (empty($attributeValue)) {
            return $this;
        }
        $attribute = $this->getAttributeModel();
        $this->getLayer()
            ->getProductCollection()
            ->addFieldToFilter($attribute->getAttributeCode(), $attributeValue);

        return $this;
    }
}
