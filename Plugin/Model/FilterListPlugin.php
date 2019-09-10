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
namespace Smile\ElasticsuiteShopbybrand\Plugin\Model;

use Smile\ElasticsuiteShopbybrand\Model\Layer\Filter\AttributeFactory as AttributeFilterFactory;
use Magento\Framework\App\RequestInterface;
use Mageplaza\Shopbybrand\Helper\Data as HelperData;

/**
 * Class FilterListPlugin
 * Usefull to fix Attribute Filter class type (abstract filter is extended by elasticsuite)
 * to keep compatibility with elastic suite
 *
 * @author    Maxime Queneau <maxime.queneau@smile.fr>
 * @copyright 2019 Smile
 */
class FilterListPlugin
{
    /** @var HelperData  */
    protected $helper;

    /** @var RequestInterface  */
    protected $request;

    /** @var AttributeFilterFactory */
    protected $attributeFilterFactory;

    /**
     * FilterListPlugin constructor.
     * @param RequestInterface $request
     * @param HelperData $helper
     * @param AttributeFilterFactory $attributeFilterFactory
     */
    public function __construct(
        RequestInterface $request,
        HelperData $helper,
        AttributeFilterFactory $attributeFilterFactory
    ) {
        $this->helper                   = $helper;
        $this->request                  = $request;
        $this->attributeFilterFactory   = $attributeFilterFactory;
    }

    /**
     * @param \Magento\Catalog\Model\Layer\FilterList $filterList
     * @param $result
     * @return mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetFilters(\Magento\Catalog\Model\Layer\FilterList $filterList, $result)
    {
        if ($this->request->getFullActionName() != 'mpbrand_index_view') {
            return $result;
        }

        $brandAttCode = $this->helper->getAttributeCode();
        foreach ($result as $key => $filter) {
            if ($filter->getRequestVar() == $brandAttCode) {
                $result[$key] = $this->attributeFilterFactory->create([
                    'data' => ['attribute_model' => $filter->getAttributeModel()],
                    'layer' => $filter->getLayer()
                ]);
                break;
            }
        }
        return $result;
    }
}
