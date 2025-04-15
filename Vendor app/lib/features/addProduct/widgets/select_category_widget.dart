import 'dart:developer';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:sixvalley_vendor_app/common/basewidgets/dropdown_decorator_widget.dart';
import 'package:sixvalley_vendor_app/common/basewidgets/no_data_screen.dart';
import 'package:sixvalley_vendor_app/features/product/domain/models/product_model.dart';
import 'package:sixvalley_vendor_app/localization/language_constrants.dart';
import 'package:sixvalley_vendor_app/features/addProduct/controllers/add_product_controller.dart';
import 'package:sixvalley_vendor_app/utill/dimensions.dart';
import 'package:sixvalley_vendor_app/utill/styles.dart';

class SelectCategoryWidget extends StatefulWidget {
  final Product? product;
  const SelectCategoryWidget({Key? key, required this.product}) : super(key: key);

  @override
  SelectCategoryWidgetState createState() => SelectCategoryWidgetState();
}

class SelectCategoryWidgetState extends State<SelectCategoryWidget> {
  @override
  Widget build(BuildContext context) {
    log("category section===>");
    return Consumer<AddProductController>(
      builder: (context, resProvider, child){
        return Column(crossAxisAlignment: CrossAxisAlignment.start,
          mainAxisAlignment: MainAxisAlignment.center,
          children: [

            const SizedBox(height: Dimensions.paddingSizeSmall),

            resProvider.categoryList != null ? resProvider.categoryList!.isNotEmpty ?
            Column(
              children: [
                DropdownDecoratorWidget(
                    child: DropdownButton<int>(
                        icon: const Icon(Icons.keyboard_arrow_down_outlined),
                        borderRadius: const BorderRadius.all(Radius.circular(Dimensions.paddingEye)),
                        value: resProvider.categoryIndex == -1 ? 0 : resProvider.categoryIndex,
                        items: resProvider.categoryIds.map((int? value) {
                          return DropdownMenuItem<int>(
                            value: resProvider.categoryIds.indexOf(value),
                            child: Text(value != 0
                                ? resProvider.categoryList![(resProvider.categoryIds.indexOf(value) -1)].name!
                                : getTranslated('select_category', context)!,
                              style: robotoMedium.copyWith(color: value == 0 ? Theme.of(context).hintColor : null),
                            ),
                          );
                        }).toList(),
                        onChanged: (int? value) {
                          resProvider.setCategoryIndex(value, true);
                          resProvider.getSubCategoryList(context, value != 0 ?
                          resProvider.categorySelectedIndex : 0, true, widget.product);},
                        isExpanded: true, underline: const SizedBox())
                ),

                resProvider.productTypeIndex == 0 ? const SizedBox(height: Dimensions.paddingSizeMedium) : const SizedBox.shrink(),
              ],
            ) : const NoDataScreen(title: 'no_category_found',) : const SizedBox.shrink(),


            resProvider.subCategoryList != null ? resProvider.subCategoryList!.isNotEmpty ?
            Column(children: [
              DropdownDecoratorWidget(
                child: DropdownButton<int>(
                  icon: const Icon(Icons.keyboard_arrow_down_outlined),
                  borderRadius: const BorderRadius.all(Radius.circular(Dimensions.paddingEye)),
                  value: resProvider.subCategoryIndex,
                  items: resProvider.subCategoryIds.map((int? value) {
                    return DropdownMenuItem<int>(
                      value: resProvider.subCategoryIds.indexOf(value),
                      child: Text(value != 0
                          ? resProvider.subCategoryList![(resProvider.subCategoryIds.indexOf(value) - 1)].name!
                          : getTranslated('sub_category', context)!,
                        style: robotoMedium.copyWith(color: value == 0 ? Theme.of(context).hintColor : null),
                      ),
                    );
                  }).toList(),
                  onChanged: (int? value) {
                    resProvider.setSubCategoryIndex(value, true);
                    resProvider.getSubSubCategoryList( value != 0 ? resProvider.subCategorySelectedIndex : 0, true);
                  },
                  isExpanded: true,
                  underline: const SizedBox(),
                ),
              ),

              resProvider.productTypeIndex == 0 ? const SizedBox(height: Dimensions.paddingSizeMedium) : const SizedBox.shrink(),
            ],
            ) : const SizedBox.shrink() : const SizedBox.shrink(),

            resProvider.subSubCategoryList != null ? resProvider.subSubCategoryList!.isNotEmpty ?
            Column(
              children: [
                DropdownDecoratorWidget(
                    child: DropdownButton<int>(
                      icon: const Icon(Icons.keyboard_arrow_down_outlined),
                      borderRadius: const BorderRadius.all(Radius.circular(Dimensions.paddingEye)),
                      value: resProvider.subSubCategoryIndex == -1 ? null :resProvider.subSubCategoryIndex,
                      items: resProvider.subSubCategoryIds.map((int? value) {
                        return DropdownMenuItem<int>(
                            value:  resProvider.subSubCategoryIds.indexOf(value),
                            child: Text(value != 0
                                ? resProvider.subSubCategoryList![(resProvider.subSubCategoryIds.indexOf(value)-1)].name!
                                : getTranslated('sub_sub_category', context)!,
                              style: robotoMedium.copyWith(color: value == 0 ? Theme.of(context).hintColor : null),
                            )
                        );
                      }).toList(),
                      onChanged: (int? value) {
                        resProvider.setSubSubCategoryIndex(value, true);
                      },
                      isExpanded: true,
                      underline: const SizedBox(),
                    ),
                ),

                resProvider.productTypeIndex == 0 ? const SizedBox(height: Dimensions.paddingSizeMedium) : const SizedBox.shrink(),
              ],
            ) : const SizedBox.shrink() : const SizedBox.shrink(),

          ],);
      },

    );
  }
}
