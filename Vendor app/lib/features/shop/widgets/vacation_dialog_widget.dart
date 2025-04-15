
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:sixvalley_vendor_app/localization/language_constrants.dart';
import 'package:sixvalley_vendor_app/features/shop/controllers/shop_controller.dart';
import 'package:sixvalley_vendor_app/main.dart';
import 'package:sixvalley_vendor_app/utill/color_resources.dart';
import 'package:sixvalley_vendor_app/utill/dimensions.dart';
import 'package:sixvalley_vendor_app/common/basewidgets/custom_button_widget.dart';
import 'package:sixvalley_vendor_app/common/basewidgets/textfeild/custom_text_feild_widget.dart';
import 'package:sixvalley_vendor_app/features/shop/widgets/vacation_calender_widget.dart';


class VacationDialogWidget extends StatelessWidget {
  final String icon;
  final String? title;
  final TextEditingController vacationNote;
  final Function onYesPressed;


  final TextEditingController? note;
  const VacationDialogWidget({Key? key, required this.icon, this.title, required this.vacationNote, required this.onYesPressed, this.note,}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Dialog(
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(Dimensions.paddingSizeSmall)),
        insetPadding: const EdgeInsets.all(30),
        clipBehavior: Clip.antiAliasWithSaveLayer,
        child: Consumer<ShopController>(
          builder: (context, shop,_) {
            return SizedBox(width: 500, child: Padding(
                padding: const EdgeInsets.all(Dimensions.paddingSizeLarge),
                child: Column(mainAxisSize: MainAxisSize.min, children: [


                  Padding(padding: const EdgeInsets.only(top: Dimensions.paddingSizeDefault, bottom: Dimensions.paddingSizeSmall),
                    child: Row(children: [
                        Flexible(child: Text(getTranslated('please_select_vacation_date_range', context)!, maxLines: 2, overflow: TextOverflow.ellipsis,)),
                      ],
                    ),
                  ),

                  InkWell(
                    splashColor: Colors.transparent,
                    onTap: ()=> showDialog(context: context, builder: (_)=> const VacationCalenderWidget()),
                    child: Padding(
                      padding: const EdgeInsets.only(bottom: Dimensions.paddingSizeDefault),
                      child: Container(
                        padding: const EdgeInsets.symmetric(vertical : Dimensions.paddingSizeSmall, horizontal: Dimensions.paddingSizeDefault),
                        decoration: BoxDecoration(
                            color:  Theme.of(context).primaryColor.withValues(alpha:.08),
                            borderRadius: BorderRadius.circular(Dimensions.paddingSizeExtraSmall)),
                        child: Row(mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            Text(shop.startDate == 'Start Date' ? getTranslated('start_date', Get.context!)! :  shop.startDate),
                            Padding(
                              padding: const EdgeInsets.symmetric(horizontal: Dimensions.paddingSizeExtraSmall),
                              child: Icon(Icons.arrow_forward_rounded,size: Dimensions.iconSizeDefault,

                                  color:  Theme.of(context).primaryColor),
                            ),
                            Text(shop.endDate == 'End Date' ? getTranslated('end_date', Get.context!)! : shop.endDate),
                          ],
                        ),
                      ),
                    ),
                  ),

                  const SizedBox(height: Dimensions.paddingSizeLarge),

                  Column(crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(getTranslated('vacation_note', context)!),
                      const SizedBox(height: Dimensions.paddingSizeSmall,),
                      CustomTextFieldWidget(border: true,
                        hintText: 'note',
                        maxLine: 2,
                        controller: vacationNote,
                      ),
                    ],
                  ),

                  const SizedBox(height: Dimensions.paddingSizeLarge),

                  Row(children: [
                    Expanded(child: InkWell(
                      onTap: () => Navigator.pop(context),
                      child: CustomButtonWidget(
                        btnTxt: getTranslated('no',context),
                        backgroundColor: ColorResources.getHint(context),
                        isColor: true,
                      ),
                    )),
                    const SizedBox(width: Dimensions.paddingSizeLarge),
                    Expanded(child: CustomButtonWidget(
                      btnTxt: getTranslated('yes',context),
                      onTap: () =>  onYesPressed(),
                    )),

                  ])
                ])),
            );
          }
        ));
  }
}